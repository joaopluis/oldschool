<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Validator;

class ProfileController extends Controller
{
    public function view(){

        $breadcrumbs = array(
            action( 'HomeController@show' ) => 'Início',
            action( 'ProfileController@view' ) => 'Perfil',
        );

        $previous = action( 'HomeController@show' );

        return view('profile', compact('breadcrumbs', 'previous'));
    }

    public function edit(){
        $breadcrumbs = array(
            action( 'HomeController@show' ) => 'Início',
            action( 'ProfileController@view' ) => 'Perfil',
            action('ProfileController@edit') => 'Editar'
        );

        $previous = action( 'ProfileController@view' );

        return view('editprofile', compact('breadcrumbs', 'previous'));
    }

    public function update(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(), ['name' => 'required',
            'email' => 'email|unique:users,email,'.$user->id,
            'current_password' => 'required_with:new_password',
            'new_password' => 'required_with:current_password',
            'confirm_password' => 'required_with:new_password|same:new_password',
        ]);

        $validator->after(function($validator) use ($request, $user) {

            if(!empty($request->current_password)) {

                $check = auth()->validate( [
                    'username' => $user->username,
                    'password' => $request->current_password
                ] );

                if ( !$check ):
                    $validator->errors()->add( 'current_password',
                        trans( 'philip.current_password_incorrect' ) );
                endif;
            }
        });

        if ($validator->fails()):
            return redirect(action('ProfileController@edit'))
                ->withErrors($validator)
                ->withInput();
        endif;

        $user->name = $request->name;
        $user->email = $request->email;

        if(!empty($request->new_password)){
            $user->password = bcrypt($request->new_password);
        }

        $user->save();

        return redirect(action('ProfileController@view'));
    }

    public function increaseSize(){
        $user = Auth::user();
        $user->font_size = $user->font_size + 0.08;
        $user->save();
        return back();
    }

    public function decreaseSize(){
        $user = Auth::user();
        $user->font_size = $user->font_size - 0.08;
        $user->save();
        return back();
    }
}
