<?php

namespace App\Http\Controllers;
use App\models\ProductoModel;
use App\models\CategoriaModel;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function __construct(){
        $this->model = new ProductoModel();
    }
    public function index(){
        $productos  = ProductoModel::all();
        $categorias = CategoriaModel::all();
        return view('producto')->with(compact('productos','categorias'));
    }
    public function ver(Request $request){
        $input = $request->all();
        $response['status'] = false;
        try {
             //Buscamos el producto con find en el modelo ProductoModel
              $ver_producto = ProductoModel::find($input['id']); 
              if ($ver_producto == NULL) {
                throw new \Exception("El producto no existe");
              } 
              $data['categ'] =  $ver_producto->id_categoria;
              $data['nombre'] = $ver_producto->nombre;
              $data['stock'] = $ver_producto->stock;
              $data['precio'] = $ver_producto->precio;
              $data['descripcion'] = $ver_producto->description;
              $data['foto'] = $ver_producto->foto; 
              //Enviamos el resultado del array data al array response data
              $response['data'] = $data;
              $response['status'] = true;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }
        //Convertimos el array a formato JSON
        echo json_encode($response); exit;
    }
    public function save(Request $request){
        /*******CAPTURAR TODOS LOS VALORES DEL FORMULARIO */
        $input = $request->all(); //la variable input es un array de todos los valores del formulario
        /***********************************************/
        $ver_producto = NULL;
        $response['status'] = false;
        try { 
            if (trim($input['nombre']) == '') {
                //CREAMOS NUESTRA EXCEPTION
                throw new \Exception("Error, el nombre del producto es requerido");
            }
            if (trim($input['categoria']) == '') {
                throw new \Exception("Error, la categoria del producto es requerido");
            }
            if (trim($input['stock']) == '') {
                throw new \Exception("Error, el stock del producto es requerido");
            }
            if (trim($input['precio']) == '') {
                throw new \Exception("Error, el precio del producto es requerido");
            }
            if (trim($input['descripcion']) == '') {
                throw new \Exception("Error, la descripcion del producto es requerido");
            } 
            if (trim($input['producto_id']) != '') {
                //SI EL INPUT producto_id ES DIFERENTE DE VACIO
                //BUSCAMOS UN PRODUCTO CON EL METODO FIND(ID) EN EL MODELO ProductoModel
                $ver_producto = ProductoModel::find($input['producto_id']);   
            }
            //Variable que me permite reemplazar un archivo. Si la variable $ver_producto es nulo significa que vamos a subir un nuevo archivo.
            $replace_file = $ver_producto == NULL ? '' : 'replace';//Si el producto existe, reemplazamos el archivo
            $req_file = $ver_producto == NULL ? true : false; 

            $respfile = $this->UploadFile($request,'foto','jpg,png,mp4','3Mb',$req_file,$replace_file);
            //Finalmente verificamos que el archivo se haya subido o reemplazado correctamente.
            if ($respfile['status'] == false) {
                throw new \Exception($respfile['message']);
            }
            //Verificar si el producto existe para editar en caso contrario crear:
            $producto = $ver_producto == NULL ? new ProductoModel() : ProductoModel::find($input['producto_id']);
            //Columnas de la tabla producto es igual al input
            $producto->nombre        = $input['nombre'];
            $producto->id_categoria  = $input['categoria'];
            $producto->stock         = $input['stock'];
            $producto->precio        = $input['precio'];
            $producto->description   = $input['descripcion'];
            $producto->foto          = $ver_producto == NULL ? $respfile['name'] : $ver_producto->foto; 
            $producto->save();//Guardamos los cambios.
            $response['status'] = true;
            //Condicion para verificar si el producto existe es Producto modificado, en caso contrio Producto registrado
            $response['message'] = $ver_producto == NULL ? 'Producto registrado' : 'Producto editado';
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }
        echo json_encode($response); exit;
    }
    public function delete(Request $request){
        $input = $request->all();  
        $response['status'] = false;
        try {
             //Buscar producto//
            $producto = ProductoModel::find($input['id']);
            //Eliminar producto
            $producto->delete();
            $response['status'] = true;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage(); 
        }
        echo json_encode($response); exit;
    }
}
