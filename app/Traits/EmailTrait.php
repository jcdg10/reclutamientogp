<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Mail;
use App\Models\User;

trait EmailTrait {

    public function sendEmailResetLink($base_url, $action_link, $body, $email, $name_user){
        try{
            if(Mail::send('email.email-forgot',['base_url'=>$base_url,'action_link'=>$action_link,'body'=>$body], function($message) use ($email, $name_user){
                    $message->from(env('MAIL_USERNAME'),env('APP_NAME'));
                    $message->to($email, $name_user)
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
   }

   public function sendWelcome($nombreUsuario, $email, $password){

        $request = new \Illuminate\Http\Request();
        $action_link = route('showDash');
        $base_url = route('showDash');
        $request->email = $email;
        $request->name_user = $nombreUsuario;
    
        try{
            if(Mail::send('email.welcome',['base_url'=>$base_url,'action_link'=>$action_link,'nombreUsuario' => $nombreUsuario,'emailUsuario' => $email, 'password' => $password], function($message) use ($request){
                    $message->from(env('MAIL_USERNAME'),env('APP_NAME'));
                    $message->to($request->email, $request->name_user)
                            ->subject('Bienvenido al '.env('APP_NAME'));
                    
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
    }

    public function sendNotification($reclutador_id){

        $action_link = route('showDash');
        $base_url = route('showDash');

        $recruiter = User::where("id","=",$reclutador_id)->firstOrFail();
        $nombreUsuario = $recruiter->name;
        $email = $recruiter->email;

        try{
            if(Mail::send('email.notification',['base_url'=>$base_url,'action_link'=>$action_link,'nombreUsuario' => $nombreUsuario,'emailUsuario' => $email], function($message) use ($email, $nombreUsuario){
                    $message->from(env('MAIL_USERNAME'),env('APP_NAME'));
                    $message->to($email, $nombreUsuario)
                            ->subject('Bienvenido al '.env('APP_NAME'));
                    
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
    }
}