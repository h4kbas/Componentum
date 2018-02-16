<?php namespace Plugins\Blog;

use Just\Core\Plugin,
    Just\Core\Route;

class Main extends Plugin{
    const tablesuffix = "blog";

    public function getGet($id){
      if($data = $this->findById($id)){
        $this->template->render('Get', [
            'post' => $data
        ]);  
      }
      else
          Route::abort(404);
    }

    public function getAll($start = null, $end = null){
        $q = $this->query();
        $q->limit($start, $end);
        $this->template->render('Get', [
            'posts' => $q->take()
        ]);  
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
        if($data = $this->findById($id)){
            $this->template->render('Update', [
                'form' => [
                    'url' => $this->url("update", $id),
                    'elements' => $this->model('Post', true),
                    'data' => $data
                ]
            ]);
        }
        else
            Route::abort(404);
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