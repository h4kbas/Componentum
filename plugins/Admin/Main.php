<?php namespace Plugins\Admin;

use Just\Core\Plugin,
    Just\Core\Route,
    Just\Core\Request;

class Main extends Plugin{
    const tablesuffix = "admin";

    public function getLogin(){  
        $this->template->render('Login', [
            'form' => [
                'url' => $this->url("login"),
                'elements' => $this->model('Admin', false, [], ['username', 'password']),
            ]
        ]);
    }

    public function postLogin(){
       try{
            $q = $this->query();
            $res = $q->where('username', '=', Request::get('username'))
                     ->where('password', '=', Request::get('password'))
                     ->limit(1)
                     ->take();
            die();
            if(!$res)
                throw new \Exception('loginfailed');
            Session::set($this->table, $res);
            $this->success('Admin', 'loggedin');
            if($use = $this->use('redirectAfterLogin'))
                $this->redirect($use, false);
            else
                $this->redirect('profile');
        }
        catch(\Exception $ex){
            $this->error('Admin', $ex);
            $this->redirect('login');
        }
    }

    public function getCreate(){
        $this->template->render('Register', [
            'form' => [
                'url' => $this->url("register"),
                'elements' => $this->model('Admin')
            ]
        ]);
    }

    public function postCreate(){
        try{
            $this->createFromRequest('Admin');
            $this->success('Admin', 'created');
        }
        catch(\Exception $ex){
            $this->error('Admin', $ex);
        }
        $this->redirect('register');
    }

    public function getUpdate($id){
        if($data = $this->findById($id)){
            $this->template->render('Update', [
                'form' => [
                    'url' => $this->url("update", $id),
                    'elements' => $this->model('Admin'),
                    'data' => $data
                ]
            ]);
        }
        else
            Route::abort(404);
    }

    public function postUpdate($id){
        try{
            $this->updateFromRequest('Admin', $id);
            $this->success('Admin', 'updated');
        }
        catch(\Exception $ex){
            $this->error('Admin', $ex);
        }
        $this->redirect('update');

    }
    
    public function postDelete($id){
        try{
            $this->deleteById($id);
            $this->success('Admin', 'deleted');
        }
        catch(\Exception $ex){
            $this->error('Admin', $ex);
        }
        $this->redirect('delete');
    }
}