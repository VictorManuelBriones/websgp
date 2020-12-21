<template>
<!--Muestra Proyectos en Administrador-->
    <div>
      <!--Modal detalles del proyecto-->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <p class="font-weight-bold">Correo: {{nota.correo}}</p>
              <p class="font-weight-bold">Teléfono: {{nota.telefono}}</p>
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
              <form @submit.prevent="editarNota(nota)">
                <select class="form-select form-control mb-2" aria-label="Default select example" v-model="nota.estatus" required>
                  <option class="text-primary" value="Aceptado">Aceptado</option>
                  <option class="text-secondary" value="En proceso">En proceso</option>
                  <option class="text-success" value="Finalizado">Finalizado</option>
                </select>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal" @click="cancelarEdicion()">Cancelar</button>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!--/Modal detalles del proyecto-->
      <h3>Badeja de proyectos</h3>
      <!--Tabla datos del proyecto-->
      <ul class="list-group my-2">
        <table class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Nombre de proyecto</th>
              <th scope="col">Tipo de proyecto</th>
              <th scope="col">Tipo de servicio</th>
              <th scope="col">Estatus</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in notas" :key="index">
              <th scope="row"> <a class="text-primary" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal" @click="editarFormulario(item)"><i class="far fa-file-alt"></i>
              {{item.nombre}}</a></th>
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
            </tr>
          </tbody>
        </table>
        <!--Paginación-->
        <nav>
          <ul class="pagination justify-content-center">
              <li class="page-item" v-if="pagination.current_page > 1">
                  <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Anterior</a>
              </li>
              <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                  <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
              </li>
              <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                  <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Siguiente</a>
              </li>
          </ul>
        </nav>
        <!--/Paginación-->
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
            estatus: '',
            correo: '',
            telefono: ''},
      pagination : {
            'total' : 0,
            'current_page' : 0,
            'per_page' : 0,
            'last_page' : 0,
            'from' : 0,
            'to' : 0,
      },
      offset : 3
    }
  },
  computed:{
      isActived: function(){
          return this.pagination.current_page;
      },
      //Calcula los elementos de la paginación
      pagesNumber: function() {
          if(!this.pagination.to) {
              return [];
          }
          
          var from = this.pagination.current_page - this.offset; 
          if(from < 1) {
              from = 1;
          }

          var to = from + (this.offset * 2); 
          if(to >= this.pagination.last_page){
              to = this.pagination.last_page;
          }  

          var pagesArray = [];
          while(from <= to) {
              pagesArray.push(from);
              from++;
          }
          return pagesArray;             

      }
  },
  created(){
    //null
  },
  methods:{
    listarProyectos(page){
      let me = this;
    var url= '/proyecto?page=' + page;
    axios.get(url).then(function (response) {
        var respuesta = response.data;
        me.notas = respuesta.proyecto.data;
        me.pagination = respuesta.pagination;

    })
    .catch(function (error) {
        console.log(error);
    });
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
      Swal.fire({
      icon: 'success',
      title: `Proyecto ${nota.estatus}`,
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true
    })
    $('#exampleModal').modal('hide')
    },
    cambiarPagina(page){
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.listarProyectos(page);
    },
  },
  mounted() {
            this.listarProyectos();
        }
}
</script>