<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12" style="">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button
              class="nav-link active"
              id="home-tab"
              data-bs-toggle="tab"
              data-bs-target="#pendents"
              type="button"
              role="tab"
              aria-controls="home"
              aria-selected="true"
            >
              Pendents
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="all-tab"
              data-bs-toggle="tab"
              data-bs-target="#all"
              type="button"
              role="tab"
              aria-controls="all"
              aria-selected="false"
            >
              Tots els documents
            </button>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div
            class="tab-pane fade show active"
            id="pendents"
            role="tabpanel"
            aria-labelledby="pendents-tab"
          >
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nom</th>
                  <th scope="col">Descripcio</th>
                  <th scope="col">Opcions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(req, key) in arrayDocs" :key="req.id">
                  <th scope="row" v-text="key + 1"></th>
                  <td v-text="req.name"></td>
                  <td v-text="req.desc"></td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-success btn-sm me-1 text-white"
                      @click="sign(req)"
                    >
                      Firmar
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div
            class="tab-pane fade"
            id="all"
            role="tabpanel"
            aria-labelledby="all-tab"
          >
            ...
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["user"],
  data() {
    return {
      user_id: this.user ? this.user : 0,
      arrayDocs: [], //Este array contendrá las tareas de nuestra bd
    };
  },
  mounted() {
    console.log("Component mounted.");
    this.getAll();
  },
  methods: {
    sign(data) {
      window.location.href = "/peticiones/firma/view/" + data.request_id;
    },
    getAll() {
      let me = this;
      let url = "/requests/user/" + me.user_id; //Ruta que hemos creado para que nos devuelva todas las tareas
      axios
        .get(url)
        .then(function (response) {
          console.log(response);
          //creamos un array y guardamos el contenido que nos devuelve el response
          me.arrayDocs = response.data.res;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
  },
};
</script>
