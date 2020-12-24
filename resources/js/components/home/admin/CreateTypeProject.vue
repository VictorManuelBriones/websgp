<template>
  <!--CRUD Tipo de Proyecto-->
  <div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarTipo">
      <i class="fa fa-plus" aria-hidden="true"> </i> tipo de proyecto
    </button>
    <!--Modal agregar Tipo de Proyecto-->
    <div class="modal fade" id="agregarTipo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo tipo de proyecto</h5>
          </div>
          <div class="modal-body">
            <form @submit.prevent="agregar">
              <label>Nombre del tipo de proyecto</label>
                <input type="text" placeholder="Nombre del tipo de proyecto" class="form-control mb-2" v-model="tipo.nombre" required>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>
                  <button class="btn btn-primary" type="submit">Agregar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--/Modal agregar Tipo de Proyecto-->
    <!--Modal editar Tipo de Proyecto-->
    <div class="modal fade" id="editarTipo" data-bs-backdrop="static"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true ">
      <div class="modal-dialog modal-dialog-centered modal">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar proyecto </h5>
            
          </div>
          <div class="modal-body">
            <form @submit.prevent="editarTipo(tipo)">
                <input type="text" placeholder="Nombre" class="form-control mb-2" v-model="tipo.nombre" required>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal" @click="cancelarEdicion()">Cancelar</button>
                  <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--/Modal editar Tipo de Proyecto-->
    <!--Tabla datos del Tipo de Proyecto-->
    <ul class="list-group my-2">
      <table class="table table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Nombre de servicio</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in tipos" :key="index">
            <th scope="row">{{item.nombre}}</th>
            <td>
              <button class="btn btn-warning btn-sm" type="submit" data-bs-toggle="modal" data-bs-target="#editarTipo" @click="editarFormulario(item)"><i class="fas fa-pen"></i> Editar</button>
              <button class="btn btn-danger btn-sm" type="submit" @click="eliminarTipo(item, index)"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>

            </td>
          </tr>
        </tbody>
      </table>
    </ul>
    <!--/Tabla datos del Tipo de Proyecto-->
  </div>
</template>

<script>
export default {
  data() {
    return {
      tipos: [],
      editarActivo2: false,
      tipo: {nombre: ''}
    }
  },
  created(){
    axios.get('/proyectot').then(res=>{
      this.tipos = res.data;
    })
  },
  methods:{
    agregar(){
      const notaNueva = this.tipo;
      this.tipo = {nombre: ''};    
      axios.post('/proyectot', notaNueva)
        .then((res) =>{
          const notaServidor = res.data;
          this.tipos.push(notaServidor);
        })
      $('#agregarTipo').modal('hide')
      Swal.fire({
      icon: 'success',
      title: 'Tipo de proyecto agregado',
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true
    })
    },
    editarFormulario(item){
      this.tipo.nombre = item.nombre;
      this.tipo.id = item.id;
      this.editarActivo2 = true;
    },
    editarTipo(tipo){
      const params = {nombre: tipo.nombre};
      axios.put(`/proyectot/${tipo.id}`, params)
        .then(res=>{
          this.editarActivo2 = false;
          const index = this.tipos.findIndex(item => item.id === tipo.id);
          this.tipos[index] = res.data;
        })
      
      Swal.fire({
      icon: 'success',
      title: 'Tipo de proyecto actualizado',
      showConfirmButton: false,
      timerProgressBar: true,
      timer: 1500
    })
    },
    eliminarTipo(tipo, index){
      Swal.fire({
      title:`¿Desea Eliminar ${tipo.nombre}?`,
      text: "No podra deshacer esta acción",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        axios.delete(`/proyectot/${tipo.id}`)
          .then(()=>{
            this.tipos.splice(index, 1);
          })
        Swal.fire(
          '¡Eliminado!',
          `"${tipo.nombre}" eliminado con Exito`,
          'success'
        )
      }
    })
    },
    cancelarEdicion(){
      this.editarActivo2 = false;
      this.tipo = {nombre: ''};
    }
  }
}
</script>

