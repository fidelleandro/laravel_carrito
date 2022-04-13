@extends('layouts.crudproducto')

@push('css')
 
@endpush

@section('content')
    <div class="contenido">
        <br>
        <!-- Button trigger modal -->
        <button onclick="add_producto(this)" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
            Agregar Producto
        </button>
        <hr>
    <!-- Modal -->
        <div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('save_product')}}" id="form_producto" method="post">
                            @csrf
                            <input type="hidden" class="producto" name="producto_id">
                            <div class="">
                                <label for="categoria">categoria</label>
                                <select name="categoria" class="form-control" id="categoria">
                                    @foreach ($categorias as $item)
                                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ingresa nombre de producto">
                            </div>
                            <div class="">
                                <label for="stock">Stock</label>
                                <input type="text" name="stock" class="form-control" id="stock" placeholder="Ingresa stock de producto">
                            </div>
                            <div class="">
                                <label for="precio">Precio</label>
                                <input type="text" name="precio" class="form-control" id="precio" placeholder="Ingresa precio de producto">
                            </div>
                            <div class="">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" class="form-control" id="descripcion" placeholder="Ingresa descripción de producto"></textarea>
                            </div>
                            <div class="">
                                <img src="{{asset('storage/images/product.jpg')}}" data="{{asset('storage/images')}}/" class="img_photo img-fluid" onchange="" alt="">
                            </div>
                            <div class="">
                                <label for="foto">Foto</label>
                                <input type="file" name="foto" onchange="imageChange(this,event)" class="form-control" id="foto">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="save_product(this)" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered dt-responsive reporte_productos">
            <thead>
                <th>Nª</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Foto</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <tr>
                        <td data-id="{{$producto['id']}}">{{$loop->iteration}}</td>
                        <td>{{$producto['nombre']}}</td>
                        <td>{{$producto['precio']}}</td>
                        <td>{{$producto['stock']}}</td>
                        <td><img height="50px" src="{{asset('storage/images/'.$producto['foto'])}}"></td>
                        <td>{{$producto['description']}}</td>
                        <td><button onclick="edit_producto(this,'{{route('ver_producto')}}')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearProductoModal">Editar</button> 
                            <button onclick="eliminar(this,'{{route('eliminar_producto')}}')" class="btn btn-danger">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> 
@endsection

@push('js') 
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{asset('js/gestionproducto.js')}}"></script> 
@endpush