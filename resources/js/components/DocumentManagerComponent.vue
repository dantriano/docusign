<template>
  <div class="row justify-content-center">
    <div class="col-md-7">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Status</th>
            <th scope="col">Opcions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(req, key) in arrayRequests" :key="req.id">
            <th scope="row" v-text="key + 1"></th>
            <td v-text="req.name + ' ' + req.surname"></td>
            <td v-text="req.status"></td>
            <td><button
                type="button"
                class="btn btn-danger btn-sm text-white"
                @click="deleteOne(req)"
              >
                Borrar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-md-5">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Opcions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, key) in arrayUsers" :key="user.id">
            <th scope="row" v-text="key + 1"></th>
            <td v-text="user.name + ' ' + user.surname"></td>
            <td>
              <button
                type="button"
                class="btn btn-success btn-sm me-1 text-white"
                @click="addUser(user)"
              >
                Añadir
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: ["edit"],
  data() {
    return {
      id: this.edit ? this.edit : 0,
      arrayRequests: [],
      arrayUsers: [],
    };
  },
  mounted() {
    console.log("Component mounted.");
    this.getAll();
    this.getUsers();
  },
  methods: {
    getAll() {
      let me = this;
      let url = "/requests/document/" + me.id;
      axios
        .get(url)
        .then(function (response) {
          console.log(response);
          //creamos un array y guardamos el contenido que nos devuelve el response
          me.arrayRequests = response.data.res;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    getUsers() {
      let me = this;
      let url = "/users/";
      axios
        .get(url)
        .then(function (response) {
          console.log(response);
          //creamos un array y guardamos el contenido que nos devuelve el response
          me.arrayUsers = response.data.res;
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    addUser(data) {
      let me = this;
      axios
        .post("/requests/", {
          user_id: data.id,
          document_id: me.id,
        })
        .then(function (response) {
          console.log(response);
          me.getAll();
        })
        .catch(function (error) {
          console.log(error);
        });
      this.getUsers();
    },
    removeUser(data) {},
    view(data) {
      window.location.href = "/documentos/edit/" + data.id;
    },
    manager(data) {
      window.location.href = "/documentos/manager/" + data.id;
    },
    deleteOne(data) {
      //Esta nos abrirá un alert de javascript y si aceptamos borrará la tarea que hemos elegido
      let me = this;
      let id = data.id;
      if (confirm("¿Seguro que deseas borrar esta tarea?")) {
        axios
          .delete("/requests/" + id)
          .then(function (response) {
            me.getAll();
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
  },
};
</script>
