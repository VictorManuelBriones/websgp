<template>
  <!--CRUD Tipo de Proyecto-->
  <div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarTipo">
      Nuevo tipo de proyecto
    </button>
    <!--Modal agregar Tipo de Proyecto-->
    <div class="modal fade" id="agregarTipo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo servicio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="agregar">
                <input type="text" placeholder="Nombre" class="form-control mb-2" v-model="nota.nombre" required>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button class="btn btn-primary" type="submit">Agregar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--/Modal agregar Tipo de Proyecto-->
    <!--Modal editar Tipo de Proyecto-->
    <div class="modal fade" id="editarTipo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar proyecto </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="editarNota(nota)">
                <input type="text" placeholder="Nombre" class="form-control mb-2" v-model="nota.nombre" required>
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
          <tr v-for="(item, index) in notas" :key="index">
            <th scope="row">{{item.nombre}}</th>
            <td>
              <button class="btn btn-warning btn-sm" type="submit" data-bs-toggle="modal" data-bs-target="#editarTipo" @click="editarFormulario(item)">Editar</button>
              <button class="btn btn-danger btn-sm" type="submit" @click="eliminarTipo(item, index)">Eliminar</button>
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
      notas: [],
      editarActivo2: false,
      nota: {nombre: ''}
    }
  },
  created(){
    axios.get('/proyectot').then(res=>{
      this.notas = res.data;
    })
  },
  methods:{
    agregar(){
      const notaNueva = this.nota;
      this.nota = {nombre: ''};    
      axios.post('/proyectot', notaNueva)
        .then((res) =>{
          const notaServidor = res.data;
          this.notas.push(notaServidor);
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
      this.nota.nombre = item.nombre;
      this.nota.id = item.id;
      this.editarActivo2 = true;
    },
    editarNota(nota){
      const params = {nombre: nota.nombre};
      axios.put(`/proyectot/${nota.id}`, params)
        .then(res=>{
          this.editarActivo2 = false;
          const index = this.notas.findIndex(item => item.id === nota.id);
          this.notas[index] = res.data;
        })
      $('#editarTipo').modal('hide')
      Swal.fire({
      icon: 'success',
      title: 'Tipo de proyecto actualizado',
      showConfirmButton: false,
      timerProgressBar: true,
      timer: 1500
    })
    },
    eliminarTipo(nota, index){
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
        axios.delete(`/proyectot/${nota.id}`)
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
      this.editarActivo2 = false;
      this.nota = {nombre: ''};
    }
  }
}
</script>

