<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;

class OnceController extends Controller
{
    //
    public function createAdmin(){
    	$users = DB::table('users')->count();

    	if($users == 0){
    		User::create([
    			'name' => 'Admin',
            	'email' => 'admin@asiangames.com',
            	'password' => bcrypt('admin'),
    		]);
    	}

    	return redirect('/');
    }
}
