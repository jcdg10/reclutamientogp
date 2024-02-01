<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Mail;

trait EmailTrait {

    public function sendResetLink(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();
        $request->name_user = $user->name;

        $token = \Str::random(64);
        \DB::table('password_resets')->insert([
              'email'=>$request->email,
              'token'=>$token,
              'created_at'=>Carbon::now(),
        ]);
        
        $action_link = route('reset.password.form',['token'=>$token,'email'=>$request->email]);
        $base_url = route('show.index');

        $body = "Recibimos tu petición para restablecer la contraseña en <b>".env('APP_NAME')."</b> asociado con el correo ".$request->email.". Tu puedes restablecer la contraseña al presionar el botón abajo";
    
        try{
            if(Mail::send('email.email-forgot',['base_url'=>$base_url,'action_link'=>$action_link,'body'=>$body], function($message) use ($request){
                    $message->from(env('MAIL_USERNAME'),env('APP_NAME'));
                    $message->to($request->email, $request->name_user)
                            ->subject('Restablecer contraseña');
                    
            })){
                return 1;
            }
            else{
                return 0;
            }
        }
        catch (\Throwable $th) {

            return $th;

        }

       return 0;
   }

    public function sendWelcome($nombreUsuario, $email, $password){

        $request = new \Illuminate\Http\Request();
        $action_link = route('show.index');
        $base_url = route('show.index');
        $request->email = $email;
        $request->name_user = $nombreUsuario;
       
        try{

            Mail::send('email.welcome',['base_url'=>$base_url,'action_link'=>$action_link,'nombreUsuario' => $nombreUsuario,'emailUsuario' => $email, 'password' => $password], function($message) use ($request){
                $message->from(env('MAIL_USERNAME'),env('APP_NAME'));
                $message->to($request->email, $request->name_user)
                        ->subject('Bienvenido a '.env('APP_NAME'));
                
            });

            return 1;
        }
        catch (\Throwable $th) {

            return $th;

        }

       return 0;
   }
}