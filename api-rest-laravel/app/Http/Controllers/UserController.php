<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
class UserController extends Controller

{
 public function pruebas (Request $request){
     return "Acción de pruebas de USER-CONTROLLER";
 }
 
//Creacion de metodo para el registro de usuarios
 public function register(Request $request){
     //recoger datos del usuario por post
     $json = $request->input('json', null);
     //Decodificar el JSON
     $params = json_decode($json);//Objeto
     $params_array = json_decode($json,true);//array
     //var_dump($params_array); die(); //codigo para validar la captura de datos
     if(!empty($params) && !empty($params_array)){
     
     //Limpiar datos
     $params_array = array_map('trim', $params_array);
     
     //validar datos
     $validate = \Validator::make($params_array,[
         'name'       => 'required|alpha',
         'surname'    => 'required|alpha',
         'email'      => 'required|email|unique:users',//unique comprueba si existe el usuario
         'password'   => 'required',
     ]);
     
     if($validate->fails()){
         //La validación ha fallado
     $data = array (
         'status'     => 'error',
         'code'       => 404,
         'message'    => 'El Usuario no se a creado',
         'errors'     => $validate->errors(),
          );
     }else{
         //Validación pasada correctamente
         
      //Cifrar la contraseña
    $pwd = hash('sha256',$params->password);

     //crear el usuario
    $user = new User();
    $user->name = $params_array['name'];
    $user->surname = $params_array['surname'];
    $user->email = $params_array['email'];
    $user->password = $pwd;
    $user->role = 'ROLE_USER';
    
       //Guardar el usuario en base de datos
    $user->save();
    
       $data = array (
         'status'     => 'success',
         'code'       => 200,
         'message'    => 'El Usuario se a creado correctamente',
           );
     }
     } else {
        $data = array (
         'status'     => 'error',
         'code'       => 404,
         'message'    => 'Los datos enviados no son correctos',

          );
     }
     

     
     
     


     //el JSON convierte el array en datos JSON
    return response()->json($data,$data['code']);
 }
  //creacion de metodo para el login de usuario
 public function login(Request $request){
     $jwtAuth = new \JwtAuth();
     //Recibir datos por POST
     $json = $request->input('json',null);
     $params = json_decode($json);
     $params_array = json_decode($json,true);
     //Validar esos datos
      $validate = \Validator::make($params_array,[

         'email'      => 'required|email',//unique comprueba si existe el usuario
         'password'   => 'required',
     ]);
     
     if($validate->fails()){
         //La validación ha fallado
     $signup = array (
         'status'     => 'error',
         'code'       => 404,
         'message'    => 'El Usuario no se a podido validar',
         'errors'     => $validate->errors()
          );
     }else{
      //Cifrar contraseña
         $pwd = hash('sha256',$params->password);
     //Devolver datos y token
        $signup = $jwtAuth->signup($params->email,$pwd);
        if(!empty($params->gettoken)){
            $signup = $jwtAuth->signup($params->email,$pwd,true);
        }
     }

   
     
     return response()->json($signup,200);
 }
 public function update(Request $request){
     //Comprobar si el usuario esta identificado
     $token = $request->header('Authorization');
     $jwtAuth = new \JwtAuth();
     $checkToken = $jwtAuth->checkToken($token);
     
//Recoger los datos por POST
    $json = $request->input('json',null);
    $params_array = json_decode($json,true);
if($checkToken && !empty($params_array)){
    
    //Sacar usuario identificado
    $user = $jwtAuth->checkToken($token,true);
    //Validar los datos
    $validate = \Validator::make($params_array,[
         'name'       => 'required|alpha',
         'surname'    => 'required|alpha',
         'email'      => 'required|email|unique:users,'.$user->sub,//unique comprueba si existe el usuario
    ]);
    //Quitar los datos que no quiero actualizar
    unset($params_array['id']);
    unset($params_array['role']);
    unset($params_array['password']);
    unset($params_array['create_at']);
    unset($params_array['remember_token']);
    //Actualizar usuario en DB
    $user_update =User::where('id', $user->sub)->update($params_array);
    //Devolver array con resultado
    $data = array (
        'code'     => 200,
        'status'   =>'success',
        'user'  =>$user_update
    );
 
}else{
    $data = array(
        'code'     => 400,
        'status'   =>'error',
        'message'  =>'El usuario no esta identificado correctamente'
    );
}
return response()->json($data,$data['code']);
 }
 public function upload (Request $request){
     
     //Recoger datos de la petición
     $image = $request->file('file0');
     
     //Validación de imagen 
     $validate = \validator::make($request->all(),[
         'file0' =>'requerid|image|mimes:jpg,jpeg,png,gif'
     ]);
     //guardar la imagen
     if(!$image ||$validate->fails()){
   $data = array(
        'code'     => 400,
        'status'   =>'error',
        'message'  =>'Error al subir imagen',
         );
     }else{
         $image_name= time().$image->getClientOriginalName();
         \Storage::disk('users')->put($image_name,\File::get($image));
         
         $data = array (
             'code'     =>200,
             'status'   =>'success',
             'image'    =>$image_name
 
    ); 
     }
   
     return response()->json($data,$data['code']);
 }
 public function getImage($filename){
     $isset = \Storage::disk('users')->exists($filename);
     if ($isset){
     $file = \Storage::disk('users')->get($filename);
     return new Response ($file,200);
     }else{
           $data = array (
             'code'     =>404,
             'status'   =>'success',
             'message'  =>'la imagen no existe'
               );
           return response()->json($data,$data['code']);
     }

 }
 public function detail($id){
     $user = User::find($id);
 if(is_object($user)){
     $data = array(
         'code'   =>200,
         'status' =>'success',
         'user'   =>$user
         
     );
 }else{
      $data = array(
         'code'   =>404,
         'status' =>'error',
         'message'   =>'El usuario no existe.'
          );
 }
 return response()->json($data,$data['code']);
 }
}
