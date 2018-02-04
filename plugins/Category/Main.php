<?php namespace Plugins\Category;

use Just\Core\Plugin,
    Just\Util\Query;

class Main extends Plugin{
    const tablesuffix = "category";

    public function getIndex(){  
    }

    public function getCreate(){
        $this->template->render('Create', [
            'form' => [
                'url' => $this->url("create"),
                'elements' => $this->model('Category')
            ]
        ]);
    }

    public function postCreate(){
        try{
            $this->createFromRequest('Category');
            $this->success('Category', 'created');
        }
        catch(\Exception $ex){
            $this->error('Category', $ex);
        }
        $this->redirect('create');
    }

    public function getUpdate($id){
        $this->template->render('Update', [
            'form' => [
                'url' => $this->url("update/$id"),
                'elements' => $this->model('Category'),
                'data' => $this->findById($id)
            ]
        ]);
    }

    public function postUpdate($id){
        try{
            $this->updateFromRequest('Category', $id);
            $this->success('Category', 'updated');
        }
        catch(\Exception $ex){
            $this->error('Category', $ex);
        }
        $this->redirect('update');

    }
    public function postDelete($id){
        try{
            $this->deleteById($id);
            $this->success('Category', 'deleted');
        }
        catch(\Exception $ex){
            $this->error('Category', $ex);
        }
        $this->redirect('delete');
    }

}