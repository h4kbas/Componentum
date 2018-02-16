<?php namespace Plugins\Auth;

use Just\Core\Plugin,
    Just\Core\Route,
    Just\Core\Request;

class Main extends Plugin{
    const tablesuffix = "user";

    public function getLogin(){  
        $this->template->render('Login', [
            'form' => [
                'url' => $this->url("login"),
                'elements' => $this->model('User', false, [], ['username', 'password']),
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
            $this->success('User', 'loggedin');
            if($use = $this->use('redirectAfterLogin'))
                $this->redirect($use, false);
            else
                $this->redirect('profile');
        }
        catch(\Exception $ex){
            $this->error('User', $ex);
            $this->redirect('login');
        }
    }

    public function getRegister(){
        $this->template->render('Register', [
            'form' => [
                'url' => $this->url("register"),
                'elements' => $this->model('User')
            ]
        ]);
    }

    public function postRegister(){
        try{
            $this->createFromRequest('User');
            $this->success('User', 'created');
        }
        catch(\Exception $ex){
            $this->error('User', $ex);
        }
        $this->redirect('register');
    }

    public function getUpdate($id){
        if($data = $this->findById($id)){
            $this->template->render('Update', [
                'form' => [
                    'url' => $this->url("update", $id),
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