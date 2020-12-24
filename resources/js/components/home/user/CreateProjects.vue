<template>
  <!--CRUD proyectos-->
  <div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarProyecto">
      <i class="fa fa-plus" aria-hidden="true"></i> Nuevo proyecto
    </button>
    <hr>
    <!--Modal agregar proyecto-->
    <div class="modal fade" id="agregarProyecto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo proyecto</h5>
          </div>
          <div class="modal-body">
            <form @submit.prevent="agregar">
                <input type="text" placeholder="Nombre" class="form-control mb-2" v-model="proyecto.nombre" required>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Tipo de Proyecto</label>
                    <select class="custom-select form-control mb-2" v-model="proyecto.tipo">
                    <option>Seleciona tipo</option>
                    <option :value="item.nombre" v-for="(item, index) in tipos" :key="index" v-text="item.nombre"></option>
                  </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Servicio</label>
                    <select class="custom-select form-control mb-2" v-model="proyecto.servicio">
                      <option>Seleciona tu servicio</option>
                      <option :value="item.nombre" v-for="(item, index) in servicios" :key="index" v-text="item.nombre"></option>
                    </select>
                  </div>
                </div>
                <textarea type="textarea" placeholder="Descripcion" class="form-control mb-2" v-model="proyecto.descripcion" required></textarea>
                <input type="hidden" value="Sin Aceptar" class="form-control mb-2" v-model="proyecto.estatus">
                <input type="email" placeholder="Correo" class="form-control mb-2" v-model="proyecto.correo" required>
                <input type="cel" placeholder="Teléfono" class="form-control mb-2" v-model="proyecto.telefono" required>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button class="btn btn-primary" type="submit">Agregar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--/Modal agregar proyecto-->
    <!--Modal editar proyecto-->
    <div class="modal fade" id="editarProyecto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar proyecto </h5>
          </div>
          <div class="modal-body">
            <form @submit.prevent="editarProyecto(proyecto)">
                <input type="text" placeholder="Nombre" class="form-control mb-2" v-model="proyecto.nombre" required>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Tipo de Proyecto</label>
                    <select class="custom-select form-control mb-2" v-model="proyecto.tipo">
                    <option>Seleciona tipo</option>
                    <option :value="item.nombre" v-for="(item, index) in tipos" :key="index" v-text="item.nombre"></option>
                  </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Servicio</label>
                    <select class="custom-select form-control mb-2" v-model="proyecto.servicio">
                      <option>Seleciona tu servicio</option>
                      <option :value="item.nombre" v-for="(item, index) in servicios" :key="index" v-text="item.nombre"></option>
                    </select>
                  </div>
                </div>
                <textarea type="textarea" placeholder="Descripcion" class="form-control mb-2" v-model="proyecto.descripcion" required></textarea>
                <input type="hidden" placeholder="Estatus" class="form-control mb-2" v-model="proyecto.estatus" required>
                <input type="email" placeholder="Correo" class="form-control mb-2" v-model="proyecto.correo" required>
                <input type="cel" placeholder="Teléfono" class="form-control mb-2" v-model="proyecto.telefono" required>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal" @click="cancelarEdicion()">Cancelar</button>
                  <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--/Modal editar proyecto-->
    <!--Modal detalles del proyecto-->
    <div class="modal fade" id="detallesProyecto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Datos del proyecto</h5>
          </div>
          <div class="modal-body">
                          <table class="table table-borderless" style="text-align:center;">
                <tbody>
                  <tr>
                    <td colspan="2" class="table-active text-primary" >  
                      Nombre
                    </td>
                       <td colspan="2" class="table-active text-primary">
                      Correo electronico
                    </td>
                    <td colspan="2" class="table-active text-primary">
                      Telefono
                    </td>
                  </tr>  
                  <tr>
                    <td colspan="2" >{{proyecto.nombre}}
                    </td>
                    <td colspan="2">{{proyecto.correo}}
                    </td>
                    <td colspan="2">{{proyecto.telefono}}
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3" class="table-active text-primary">Tipo de Servicio
                    </td>
                    <td colspan="3" class="table-active text-primary">
                      Tipo de Proyecto
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">{{proyecto.servicio}}
                      </td>
                      <td colspan="3">{{proyecto.tipo}}
                        </td>
                    </tr>
                </tbody>
              </table>
            <div class="accordion" id="accordionExample">
              <div class="card">
                <div class="card-header" id="headingOne">
                  <h6 class="mb-0 text-center">
                    <a class="font-weight-normal text-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Descripción
                    </a>
                  </h6>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    {{proyecto.descripcion}}
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-outline-dark" data-bs-dismiss="modal" @click="cancelarEdicion()">Cerrar</button>
  
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/Modal detalles del proyecto-->
    <!--Tabla datos del proyecto-->
    <ul class="list-group my-2">
      <table class="table table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Nombre de proyecto</th>
            <th scope="col">Tipo de proyecto</th>
            <th scope="col">Tipo de servicio</th>
            <th scope="col">Estatus</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in proyectos" :key="index">
            <th scope="row"> <a class="text-primary" type="submit" data-bs-toggle="modal" data-bs-target="#detallesProyecto" @click="editarFormulario(item)">{{item.nombre}}</a></th>
            <td>{{item.tipo}}</td>
            <td>{{item.servicio}}</td>
            <td v-if="item.estatus === 'Sin Aceptar'">
              <span class="badge badge-light">{{item.estatus}}</span>
            </td>
            <td v-if="item.estatus == 'Aceptado'">
              <span class="badge badge-info">{{item.estatus}}</span>
            </td>
            <td v-if="item.estatus == 'En proceso'">
              <span class="badge badge-secondary">{{item.estatus}}</span>
            </td>
            <td v-if="item.estatus == 'Finalizado'">
              <span class="badge badge-success">{{item.estatus}}</span>
            </td>
            <td>
              <button class="btn btn-warning btn-sm" type="submit" data-bs-toggle="modal" data-bs-target="#editarProyecto" @click="editarFormulario(item)"><i class="fas fa-pen"></i> Editar</button>
              <button class="btn btn-danger btn-sm" type="submit" @click="eliminarProyecto(item, index)"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
    </ul>
    <!--/Tabla datos del proyecto-->
  </div> 
</template>

<script>
export default {
  data() {
    return {
      proyectos: [],
      proyecto: {nombre: '',
            tipo: '',
            servicio: '',
            descripcion: '',
            estatus: 'Sin Aceptar',
            correo: '',
            telefono: ''},
      tipos: [],
      tipo: {nombre: ''},
      servicios: [],
      servicio: {nombre: ''}
    }
  },
  created(){
    axios.get('/proyecto').then(res=>{
      this.proyectos = res.data;
    })
    axios.get('/proyectot').then(res=>{
      this.tipos = res.data;
    })
    axios.get('/proyectos').then(res=>{
      this.servicios = res.data;
    })
  },
  methods:{
    agregar(){
      //console.log(this.proyecto.nombre,this.proyecto.tipo, this.proyecto.servicio, this.proyecto.descripcion, this.proyecto.estatus, this.proyecto.correo, this.proyecto.telefono)
      const notaNueva = this.proyecto;
      this.proyecto = {nombre: '', tipo: '', servicio: '', descripcion: '', estatus: '',correo: '', telefono: ''};    
      axios.post('/proyecto', notaNueva)
        .then((res) =>{
          const notaServidor = res.data;
          this.proyectos.push(notaServidor);
        })
      Swal.fire({
      icon: 'success',
      title: 'Proyecto Agregado',
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true
    })
    $('#agregarProyecto').modal('hide')
    },
    editarFormulario(item){
        this.proyecto.id = item.id;
        this.proyecto.nombre = item.nombre;
        this.proyecto.tipo = item.tipo;
        this.proyecto.servicio = item.servicio;
        this.proyecto.descripcion = item.descripcion;
        this.proyecto.estatus = item.estatus;
        this.proyecto.correo = item.correo;
        this.proyecto.telefono = item.telefono;
    },
    editarProyecto(proyecto){
      const params = {nombre: proyecto.nombre, tipo: proyecto.tipo, servicio: proyecto.servicio, descripcion: proyecto.descripcion, estatus: proyecto.estatus, correo: proyecto.correo, telefono: proyecto.telefono};
      axios.put(`/proyecto/${proyecto.id}`, params)
        .then(res=>{
          const index = this.proyectos.findIndex(item => item.id === proyecto.id);
          this.proyectos[index] = res.data;
        })
      Swal.fire({
      icon: 'success',
      title: 'Información actualizada',
      showConfirmButton: false,
      timerProgressBar: true,
      timer: 1500
    })
    
    },
    eliminarProyecto(proyecto, index){
      Swal.fire({
      title:`¿Desea Eliminar ${proyecto.nombre}?`,
      text: "No podra deshacer esta acción",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        axios.delete(`/proyecto/${proyecto.id}`)
          .then(()=>{
            this.proyectos.splice(index, 1);
          })
        Swal.fire(
          '¡Eliminado!',
          `"${proyecto.nombre}" eliminado con Exito`,
          'success'
        )
      }
    })
    },
    cancelarEdicion(){
      this.proyecto = {nombre: '',
            tipo: '',
            servicio: '',
            descripcion: '',
            estatus:'',
            correo: '',
            telefono: ''};
    }
    }
  }

</script>