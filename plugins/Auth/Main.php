<?php namespace Plugins\Auth;

use Just\Core\Plugin,
    Just\Core\Route;

class Main extends Plugin{
    const tablesuffix = "user";

    public function getIndex(){  
    }

    public function getCreate(){
        $this->template->render('Create', [
            'form' => [
                'url' => $this->url("create"),
                'elements' => $this->model('User')
            ]
        ]);
    }

    public function postCreate(){
        try{
            $this->createFromRequest('User');
            $this->success('User', 'created');
        }
        catch(\Exception $ex){
            $this->error('User', $ex);
        }
        $this->redirect('create');
    }

    public function getUpdate($id){
        if($data = $this->findById($id)){
            $this->template->render('Update', [
                'form' => [
                    'url' => $this->url("update/$id"),
                    'elements' => $this->model('User'),
                    'data' => $data
                ]
            ]);
        }
        else
            Route::abort(404);
    }

    public function postUpdate($id){
        try{
            $this->updateFromRequest('User', $id);
            $this->success('User', 'updated');
        }
        catch(\Exception $ex){
            $this->error('User', $ex);
        }
        $this->redirect('update');

    }
    public function postDelete($id){
        try{
            $this->deleteById($id);
            $this->success('User', 'deleted');
        }
        catch(\Exception $ex){
            $this->error('User', $ex);
        }
        $this->redirect('delete');
    }

}