<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8" style="max-width: 30rem">
        <div class="card">
          <div class="card-body">
            <div class="login-box">
              <h1 style="text-align: center">Welcome to Docusign</h1>
              <div class="row justify-content-center">

                <div class="col-xs-12" style="text-align: center">
                <form>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input
                      type="email"
                      class="form-control"
                      id="exampleInputEmail1"
                      aria-describedby="emailHelp"
                      placeholder="Enter email"
                    />
                  </div>

                  <div class="col-xs-12" style="text-align: center">
                    <label
                      id="j_idt22"
                      class="ui-outputlabel ui-widget"
                      style="padding-bottom: 20px"
                      >Acceder con</label
                    ><img
                      src="/img/logo-clave.png"
                      width="130"
                      class="margin"
                    />
                  </div>
                  <input
                    type="submit"
                    value="CL@VE"
                    class="btn btn-block"
                    style="
                      width: 60%;
                      display: inline;
                      color: white;
                      background-color: #3c8dbc;
                    "
                  />

                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
