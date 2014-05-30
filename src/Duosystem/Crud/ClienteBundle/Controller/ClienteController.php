<?php

namespace Duosystem\Crud\ClienteBundle\Controller;

use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToLocalizedStringTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Duosystem\Crud\ClienteBundle\Entity\Cliente;
use Duosystem\Crud\ClienteBundle\Form\ClienteType;


/**
 * Cliente controller.
 *
 * @Route("/cliente")
 */
class ClienteController extends Controller
{
    /**
     * Lista todas as entidades Clientes.
     *
     * @Route("/", name="cliente_lista")
     * @Template()
     */
    public function indexAction()
    {

        $titulo = "Clientes";
        $request = $this->getRequest();

        //verifica se temos um POST
        if ($request->isMethod('POST')) {

            $filtro = $this->get('request')->request->get('filtro');

           $clientes = $this->getDoctrine()->getRepository('ClienteBundle:Cliente')
                ->findNomeLike($filtro);
}
        else{
            $clientes = $this->getDoctrine()
                ->getRepository('ClienteBundle:Cliente')
                ->findAll();
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                            $clientes,
                            $this->get('request')->query->get('page', 1)/*page number*/, 10/*limit per page*/
                        );

        return array(
            'titulo'=> $titulo,
            'pagination' => $pagination
        );

    }

    /**
     * Mostra o formulário para cadastrar um novo Cliente.
     *
     * @Route("/cadastrar", name="cliente_cadastrar")
     * @Template()
     */
    public function cadastrarAction()
    {
        $titulo = "Cadastro de Cliente";

        $request = $this->getRequest();

        $cliente = new Cliente();

        $form = $this->createForm(new ClienteType(), $cliente);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($cliente);
            $em->flush();

            return $this->redirect($this->generateUrl('cliente_lista'));
        }

        return array(
                'form' => $form->createView(),
                'titulo' => $titulo,
                'cliente' => $cliente
            );
    }

    /**
     * Encontra e mostra um Cliente.
     *
     * @Route("/detalhes/{id}", name="cliente_detalhes")
     * @Method("GET")
     * @Template()
     */
    public function detalhesAction($id){

        $titulo = "Detalhes";

        $cliente = $this->getDoctrine()
            ->getRepository('ClienteBundle:Cliente')
            ->findOneById($id);

        if (!$cliente) {
            throw $this->createNotFoundException('Não existe cliente com o ID '.$id);
        }


        return array(
                'titulo' => $titulo,
                'cliente' => $cliente
         );
    }

    /**
     * Mostra o formulário para editar um Cliente.
     *
     * @Route("/editar/{id}", name="cliente_editar")
     * @Template()
     */
    public function editarAction($id)
    {
        $titulo = "Edição de Cliente";

        $request = $this->getRequest();

        $cliente = $this->getDoctrine()
            ->getRepository('ClienteBundle:Cliente')
            ->findOneById($id);

        if (!$cliente) {
            throw $this->createNotFoundException('Não existe cliente com o ID '.$id);
        }

        $enderecos_originais = array();
        $contatos_originais = array();

        // Cria array dos objetos(relacionamentos) atuais existentes no banco de dados
        foreach ($cliente->getEnderecos() as $endereco) $enderecos_originais[] = $endereco;
        foreach ($cliente->getContatos() as $contato) $contatos_originais[] = $contato;

        $form = $this->createForm(new ClienteType(), $cliente);

        //verifica se temos um POST
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                // Percorrer $enderecos_originais para verificar enderecos que não estao mais presentes
                foreach ($cliente->getEnderecos() as $endereco) {
                    foreach ($enderecos_originais as $key => $toDel) {
                        if ($toDel->getId() === $endereco->getId()) {
                            unset($enderecos_originais[$key]);
                        }
                    }
                }
                // remover a relação entre Cliente e Endereco
                foreach ($enderecos_originais as $endereco) {
                    // Para excluir Endereco do banco...
                    $em->remove($endereco);
                }

                // Percorrer $contatos_originais para verificar contatos que não estao mais presentes
                foreach ($cliente->getContatos() as $contato) {
                    foreach ($contatos_originais as $key => $toDel) {
                        if ($toDel->getId() === $contato->getId()) {
                            unset($contatos_originais[$key]);
                        }
                    }
                }
                // remover a relação entre Cliente e Contato
                foreach ($contatos_originais as $contato) {
                    $em->remove($contato);
                }

                $em->persist($cliente);
                $em->flush();

                // redireciona para listagem
                return $this->redirect($this->generateUrl('cliente_lista'));
            }
        }

        //renderiza a view
        return array(
                'form' => $form->createView(),
                'titulo' => $titulo,
                'cliente' => $cliente,
            );
    }

    /**
     * Deleta Cliente.
     *
     * @Route("/excluir/{id}", name="cliente_excluir")
     */
    public function excluirAction($id)
    {
        //$titulo = "Excluir de Cliente";

        $request = $this->getRequest();

        $cliente = $this->getDoctrine()
            ->getRepository('ClienteBundle:Cliente')
            ->findOneById($id);

        if (!$cliente) {
            throw $this->createNotFoundException('Não existe cliente com o ID '.$id);
        }
        else {

            $em = $this->getDoctrine()->getManager();
            $em->remove($cliente);
            $em->flush();

            // redireciona para listagem
            return $this->redirect($this->generateUrl('cliente_lista'));
        }

    }


}