<template>
<!--Muestra Proyectos en Administrador-->
    <div>
      <!--Modal detalles del proyecto-->
      <div class="modal fade" id="exampleModal" data-bs-backdrop="static"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <hr>
              <form @submit.prevent="editarNota(proyecto)">
                <label class="text-primary">
                  Cambiar estatus
                </label>
                <select class="form-select form-control mb-2" aria-label="Default select example" v-model="proyecto.estatus" required>
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
            <tr v-for="(item, index) in proyectos" :key="index">
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
      proyectos: [],
      proyecto: {nombre: '',
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
        me.proyectos = respuesta.proyecto.data;
        me.pagination = respuesta.pagination;

    })
    .catch(function (error) {
        console.log(error);
    });
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
    editarNota(proyecto){
      const params = {nombre: proyecto.nombre, tipo: proyecto.tipo, servicio: proyecto.servicio, descripcion: proyecto.descripcion, estatus: proyecto.estatus, correo: proyecto.correo, telefono: proyecto.telefono};
      axios.put(`/proyecto/${proyecto.id}`, params)
        .then(res=>{
          const index = this.proyectos.findIndex(item => item.id === proyecto.id);
          this.proyectos[index] = res.data;
        })
      Swal.fire({
      icon: 'success',
      title: `Proyecto ${proyecto.estatus}`,
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true
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