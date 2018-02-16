<?php namespace Plugins\Page;

use Just\Core\Plugin,
    Just\Core\Route;

class Main extends Plugin{
    const tablesuffix = "page";

    public function getGet($slug){
        $q = $this->query();
        $res = $q
                ->limit(1)
                ->where('slug', '=', $slug)
                -take();
        if($res){
          $this->template->render('Get', [
              'page' => $res
          ]);  
        }
        else
            Route::abort(404);
      }
  
    public function getAll($start = null, $end = null){
        $q = $this->query();
        $q->limit($start, $end);
        $this->template->render('Get', [
            'pages' => $q->take()
        ]);  
    }

    public function getIndex(){  
    }

    public function getCreate(){
        $this->template->render('Create', [
            'form' => [
                'url' => $this->url("create"),
                'elements' => $this->model('Page')
            ]
        ]);
    }

    public function postCreate(){
        try{
            $this->createFromRequest('Page');
            $this->success('Page', 'created');
        }
        catch(\Exception $ex){
            $this->error('Page', $ex);
        }
        $this->redirect('create');
    }

    public function getUpdate($id){
        if($data = $this->findById($id)){
            $this->template->render('Update', [
                'form' => [
                    'url' => $this->url("update", $id),
                    'elements' => $this->model('Page'),
                    'data' => $data
                ]
            ]);
        }
        else
            Route::abort(404);
    }

    public function postUpdate($id){
        try{
            $this->updateFromRequest('Page', $id);
            $this->success('Page', 'updated');
        }
        catch(\Exception $ex){
            $this->error('Page', $ex);
        }
        $this->redirect('update');

    }
    public function postDelete($id){
        try{
            $this->deleteById($id);
            $this->success('Page', 'deleted');
        }
        catch(\Exception $ex){
            $this->error('Page', $ex);
        }
        $this->redirect('delete');
    }

}