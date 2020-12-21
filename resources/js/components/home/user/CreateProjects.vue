<template>
  <!--CRUD proyectos-->
  <div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarProyecto">
      Nuevo proyecto
    </button>
    <!--Modal agregar proyecto-->
    <div class="modal fade" id="agregarProyecto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo proyecto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="agregar">
                <input type="text" placeholder="Nombre" class="form-control mb-2" v-model="nota.nombre" required>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Tipo de Proyecto</label>
                    <select class="custom-select form-control mb-2" v-model="nota.tipo">
                    <option>Seleciona tipo</option>
                    <option :value="item.nombre" v-for="(item, index) in tipos" :key="index" v-text="item.nombre"></option>
                  </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Servicio</label>
                    <select class="custom-select form-control mb-2" v-model="nota.servicio">
                      <option>Seleciona tu servicio</option>
                      <option :value="item.nombre" v-for="(item, index) in servicios" :key="index" v-text="item.nombre"></option>
                    </select>
                  </div>
                </div>
                <textarea type="textarea" placeholder="Descripcion" class="form-control mb-2" v-model="nota.descripcion" required></textarea>
                <input type="hidden" value="Sin Aceptar" class="form-control mb-2" v-model="nota.estatus">
                <input type="email" placeholder="Correo" class="form-control mb-2" v-model="nota.correo" required>
                <input type="cel" placeholder="Teléfono" class="form-control mb-2" v-model="nota.telefono" required>
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
    <div class="modal fade" id="editarProyecto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar proyecto </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="editarNota(nota)">
                <input type="text" placeholder="Nombre" class="form-control mb-2" v-model="nota.nombre" required>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Tipo de Proyecto</label>
                    <select class="custom-select form-control mb-2" v-model="nota.tipo">
                    <option>Seleciona tipo</option>
                    <option :value="item.nombre" v-for="(item, index) in tipos" :key="index" v-text="item.nombre"></option>
                  </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Servicio</label>
                    <select class="custom-select form-control mb-2" v-model="nota.servicio">
                      <option>Seleciona tu servicio</option>
                      <option :value="item.nombre" v-for="(item, index) in servicios" :key="index" v-text="item.nombre"></option>
                    </select>
                  </div>
                </div>
                <textarea type="textarea" placeholder="Descripcion" class="form-control mb-2" v-model="nota.descripcion" required></textarea>
                <input type="hidden" placeholder="Estatus" class="form-control mb-2" v-model="nota.estatus" required>
                <input type="email" placeholder="Correo" class="form-control mb-2" v-model="nota.correo" required>
                <input type="cel" placeholder="Teléfono" class="form-control mb-2" v-model="nota.telefono" required>
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
    <div class="modal fade" id="detallesProyecto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Datos del proyecto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="font-weight-bold">Nombre: {{nota.nombre}}</p>
            <p class="font-weight-bolder">Tipo: {{nota.tipo}}</p>
            <p class="font-weight-normal">Servicio: {{nota.servicio}}</p>
            <div class="accordion" id="accordionExample">
              <div class="card">
                <div class="card-header" id="headingOne">
                  <h2 class="mb-0">
                    <a class="font-weight-normal text-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Descripción
                    </a>
                  </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    {{nota.descripcion}}
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" >Aceptar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/Modal detalles del proyecto-->
    <h3>Mis proyectos</h3>
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
          <tr v-for="(item, index) in notas" :key="index">
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
              <button class="btn btn-warning btn-sm" type="submit" data-bs-toggle="modal" data-bs-target="#editarProyecto" @click="editarFormulario(item)">Editar</button>
              <button class="btn btn-danger btn-sm" type="submit" @click="eliminarProyecto(item, index)">Eliminar</button>
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
      notas: [],
      nota: {nombre: '',
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
      this.notas = res.data;
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
      //console.log(this.nota.nombre,this.nota.tipo, this.nota.servicio, this.nota.descripcion, this.nota.estatus, this.nota.correo, this.nota.telefono)
      const notaNueva = this.nota;
      this.nota = {nombre: '', tipo: '', servicio: '', descripcion: '', estatus: '',correo: '', telefono: ''};    
      axios.post('/proyecto', notaNueva)
        .then((res) =>{
          const notaServidor = res.data;
          this.notas.push(notaServidor);
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
        this.nota.id = item.id;
        this.nota.nombre = item.nombre;
        this.nota.tipo = item.tipo;
        this.nota.servicio = item.servicio;
        this.nota.descripcion = item.descripcion;
        this.nota.estatus = item.estatus;
        this.nota.correo = item.correo;
        this.nota.telefono = item.telefono;
    },
    editarNota(nota){
      const params = {nombre: nota.nombre, tipo: nota.tipo, servicio: nota.servicio, descripcion: nota.descripcion, estatus: nota.estatus, correo: nota.correo, telefono: nota.telefono};
      axios.put(`/proyecto/${nota.id}`, params)
        .then(res=>{
          const index = this.notas.findIndex(item => item.id === nota.id);
          this.notas[index] = res.data;
        })
      $('#editarProyecto').modal('hide')
      Swal.fire({
      icon: 'success',
      title: 'Información actualizada',
      showConfirmButton: false,
      timerProgressBar: true,
      timer: 1500
    })
    
    },
    eliminarProyecto(nota, index){
      Swal.fire({
      title:`¿Desea Eliminar ${nota.nombre}?`,
      text: "No podra deshacer esta acción",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        axios.delete(`/proyecto/${nota.id}`)
          .then(()=>{
            this.notas.splice(index, 1);
          })
        Swal.fire(
          '¡Eliminado!',
          `"${nota.nombre}" eliminado con Exito`,
          'success'
        )
      }
    })
    },
    cancelarEdicion(){
      this.nota = {nombre: '',
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