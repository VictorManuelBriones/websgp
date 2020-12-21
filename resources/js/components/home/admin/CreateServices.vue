<template>
<!--CRUD Servicios-->
  <div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarServicio">
      <i class="fa fa-plus" aria-hidden="true"></i>
      Nuevo servicio
    </button>
    <!--Modal agregar servicio-->
    <div class="modal fade" id="agregarServicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" >Agregar nuevo servicio</h5>
          </div>
          <div class="modal-body">
            <form @submit.prevent="agregar">
                <input type="text" placeholder="Nombre" class="form-control mb-2" v-model="nota.nombre" required>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>
                  <button class="btn btn-primary" type="submit">Agregar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--/Modal agregar servicio-->
    <!--Modal editar servicio-->
    <div class="modal fade" id="editarServicio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar proyecto </h5>
          </div>
          <div class="modal-body">
            <form @submit.prevent="editarNota(nota)">
                <input type="text" placeholder="Nombre" class="form-control mb-2" v-model="nota.nombre" required>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-dark" data-bs-dismiss="modal" @click="cancelarEdicion()">Cancelar</button>
                  <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--/Modal editar servicio-->
    <!--Tabla datos del servicio-->
    <ul class="list-group my-2">
      <table class="table table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Nombre de servicio</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in notas" :key="index">
            <th scope="row">{{item.nombre}}</th>
            <td>
              <button class="btn btn-warning btn-sm" type="submit" data-bs-toggle="modal" data-bs-target="#editarServicio" @click="editarFormulario(item)">
                <i class="fas fa-pen"></i>
                Editar
              </button>
              <button class="btn btn-danger btn-sm" type="submit" @click="eliminarServicio(item, index)">
                <i class="fa fa-trash" aria-hidden="true"></i> 
                Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
    </ul>
    <!--/Tabla datos del servicio-->
  </div>
</template>

<script>
export default {
  data() {
    return {
      notas: [],
      nota: {nombre: ''}
    }
  },
  created(){
    axios.get('/proyectos').then(res=>{
      this.notas = res.data;
    })
  },
  methods:{
    agregar(){
      const notaNueva = this.nota;
      this.nota = {nombre: ''};    
      axios.post('/proyectos', notaNueva)
        .then((res) =>{
          const notaServidor = res.data;
          this.notas.push(notaServidor);
        })
      Swal.fire({
      icon: 'success',
      title: 'Servicio agregado',
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true
    })
    $('#agregarServicio').modal('hide')
    },
    editarFormulario(item){
      this.nota.nombre = item.nombre;
      this.nota.id = item.id;
    },
    editarNota(nota){
      const params = {nombre: nota.nombre};
      axios.put(`/proyectos/${nota.id}`, params)
        .then(res=>{
          const index = this.notas.findIndex(item => item.id === nota.id);
          this.notas[index] = res.data;
        })
      Swal.fire({
      icon: 'success',
      title: 'Servicio actualizado',
      showConfirmButton: false,
      timerProgressBar: true,
      timer: 1500
    })
    },
    eliminarServicio(nota, index){
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
        axios.delete(`/proyectos/${nota.id}`)
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
      this.nota = {nombre: ''};
    },
  }
}
</script>

