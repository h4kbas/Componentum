<?php namespace Plugins\Blog;

use Just\Core\Plugin,
    Just\Util\Query;

class Main extends Plugin{
    const tablesuffix = "blog";

    public function getIndex(){  
    }

    public function getCreate(){
        $this->template->render('Create', [
            'form' => [
                'url' => $this->url("create"),
                'elements' => $this->model('Post', true)
            ]
        ]);
    }

    public function postCreate(){
        try{
            $this->createFromRequest('Post');
            $this->success('Post', 'created');
        }
        catch(\Exception $ex){
            $this->error('Post', $ex);
        }
        $this->redirect('create');
    }

    public function getUpdate($id){
        $this->template->render('Update', [
            'form' => [
                'url' => $this->url("update/$id"),
                'elements' => $this->model('Post', true),
                'data' => $this->findById($id)
            ]
        ]);
    }

    public function postUpdate($id){
        try{
            $this->updateFromRequest('Post', $id);
            $this->success('Post', 'updated');
        }
        catch(\Exception $ex){
            $this->error('Post', $ex);
        }
        $this->redirect('update');

    }
    public function postDelete($id){
        try{
            $this->deleteById($id);
            $this->success('Post', 'deleted');
        }
        catch(\Exception $ex){
            $this->error('Post', $ex);
        }
        $this->redirect('delete');
    }

}