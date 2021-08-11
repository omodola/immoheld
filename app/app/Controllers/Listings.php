<?php

namespace App\Controllers;

use Handlers\Listings\CreateListingHandler;
use Handlers\Listings\DeleteListingHandler;
use Handlers\Listings\EditListingHandler;
use Handlers\Listings\GetListingByIdHandler;
use Handlers\Listings\GetListingHandler;
use Handlers\Listings\PopulateDataHandler;

class Listings extends BaseController
{
    public function index()
    {
        $this->get();

    }

    public function get()
    {
        $handler = new GetListingHandler();
        $data = [
            'listings' => $handler->handle($this->request->getGet()),
            'errors' => $handler->errors,
            'data' => $handler->data,
        ];

        echo view('listings', $data);

    }

    public function getById(int $id)
    {
        $handler = new GetListingByIdHandler();
        $data = [
            'listings' => $handler->handle($id),
            'errors' => $handler->errors,
            'data' => $handler->data,
        ];
        echo view('details_page', $data);

    }

    public function post()
    {
        $handler = new CreateListingHandler();
        $data = [
            'listings' => $handler->handle($this->request->getPost()),
            'errors' => $handler->errors,
            'data' => $handler->data,
        ];


        echo '<pre>'; print_r($data);;
    }

    public function edit(int $id)
    {
        $handler = new EditListingHandler();
        $args = $this->request->getPost();
        $args['id'] = $id;
        $data = [
            'listings' => $handler->handle($args),
            'errors' => $handler->errors,
            'data' => $handler->data,
        ];


        echo '<pre>';print_r($data);echo '</pre>'; die();
    }

    public function delete(int $id)
    {
        $handler = new DeleteListingHandler();
        $data = [
            'listings' => $handler->handle($id),
            'errors' => $handler->errors,
            'data' => $handler->data,
        ];


        echo '<pre>';print_r($data);echo '</pre>'; die();
    }

    public function populate(int $size=11)
    {
        $handler = new PopulateDataHandler();
        $args = $this->request->getPost();
        $args['itemsToAdd'] = $size;
        $data = [
            'listings' => $handler->handle($args),
            'errors' => $handler->errors,
            'data' => $handler->data,
        ];


        echo '<pre>';print_r($data);echo '</pre>'; die();
    }
}