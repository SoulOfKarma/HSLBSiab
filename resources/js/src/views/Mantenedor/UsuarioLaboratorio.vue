<template>
    <div>
        <vx-card title="Usuarios de Laboratorio">
            <div>
                <vs-button color="primary" type="filled" @click="popLabUsuario"
                    >Agregar Usuario de Laboratorio</vs-button
                >
            </div>
            <br />
            <div>
                <vx-card>
                    <vue-good-table
                        :columns="columns"
                        :rows="rows"
                        :pagination-options="PageOptions"
                        theme="black-rhino"
                    >
                        <template slot="table-row" slot-scope="props">
                            <!-- Column: Name -->
                            <span
                                v-if="props.column.field === 'fullName'"
                                class="text-nowrap"
                            >
                            </span>
                            <span v-else-if="props.column.field === 'action'">
                                <plus-circle-icon
                                    content="Modificar Usuario de Laboratorio"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarLabUsuario(
                                            props.row.id,
                                            props.row.RUN,
                                            props.row.nombreUsuLab,
                                            props.row.apellidoUsuLab
                                        )
                                    "
                                ></plus-circle-icon>
                            </span>
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </vx-card>
            </div>
            <vs-popup
                classContent="AgregarUsuLab"
                title="Agregar Usuario de Laboratorio"
                :active.sync="popUpLabUsuario"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-full mt-5">
                                <h6>Run Usuario</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="runUsuario"
                                    v-on:blur="formatear_run"
                                />
                                <span
                                    style="font-size: 10px; color: red; margin-left: 10px;"
                                    v-if="val_run"
                                    >Run incorrecto</span
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="nombreUsuario"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Apellido</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="apellidoUsuario"
                                />
                            </div>
                        </div>
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="popUpLabUsuario = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="AgregarLabUsuario"
                                    color="warning"
                                    type="filled"
                                    class="w-full m-1"
                                    >Agregar Usuario</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="UsuLabMod"
                title="Modificar Usuario del Laboratorio"
                :active.sync="popUpLabUsuarioMod"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-full mt-5">
                                <h6>Run Usuario</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="runUsuario"
                                    v-on:blur="formatear_run"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="nombreUsuario"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Apellido</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="apellidoUsuario"
                                />
                            </div>
                        </div>
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="popUpLabUsuarioMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="ModificarLabUsuario"
                                    color="warning"
                                    type="filled"
                                    class="w-full m-1"
                                    >Modificar Usuario</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
        </vx-card>
    </div>
</template>
<script>
import axios from "axios";
import router from "@/router";
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { PlusCircleIcon } from "vue-feather-icons";
import { validate, clean, format } from "rut.js";
import Vue from "vue";
import store from "../ScriptMenus/store.js";
import VueTippy, { TippyComponent } from "vue-tippy";
Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);

export default {
    components: {
        VueGoodTable,
        "v-select": vSelect,
        quillEditor,
        PlusCircleIcon
    },
    data() {
        return {
            //Datos Locales - Variables de Entorno
            localVal: process.env.MIX_APP_URL,
            editorOption: {
                modules: {
                    toolbar: [
                        ["bold", "italic", "underline", "strike"],
                        ["blockquote", "code-block"],
                        [{ header: 1 }, { header: 2 }],
                        [{ list: "ordered" }, { list: "bullet" }],
                        [{ indent: "-1" }, { indent: "+1" }],
                        [{ direction: "rtl" }],
                        [{ font: [] }],
                        [{ align: [] }],
                        ["clean"]
                    ]
                }
            },
            //Datos Campos
            PageOptions: store.state.PageOptions,
            popUpLabUsuario: false,
            popUpLabUsuarioMod: false,
            runUsuario: "",
            nombreUsuario: "",
            apellidoUsuario: "",
            val_run: false,
            idMod: 0,
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "Run Usuario",
                    field: "RUN",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Nombre Usuario",
                    field: "nombreUsuLab",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Apellido Usuario",
                    field: "apellidoUsuLab",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            //Datos Listado Proveedor
            rows: []
        };
    },
    methods: {
        //Metodos Reusables
        formatear_run() {
            if (this.runUsuario == "" || this.runUsuario == null) {
                //console.log("Sin Rut");
                this.val_run = false;
            } else {
                this.runUsuario = format(this.runUsuario);
                this.val_run = !validate(this.runUsuario);
            }
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 1000);
        },
        isNumber: function(evt) {
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (
                charCode > 31 &&
                (charCode < 48 || charCode > 57) &&
                charCode !== 46
            ) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        limpiarCampos() {
            try {
                this.runUsuario = "";
                this.nombreUsuario = "";
                this.apellidoUsuario = "";
                this.idMod = 0;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popLabUsuario() {
            try {
                this.popUpLabUsuario = true;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarLabUsuario(id, run, nom, ape) {
            try {
                this.limpiarCampos();
                this.popUpLabUsuarioMod = true;
                this.idMod = id;
                this.runUsuario = run;
                this.nombreUsuario = nom;
                this.apellidoUsuario = ape;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD Servicios
        TraerLabUsuario() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetLabUsuario", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.rows = res.data;
                        if (this.rows.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de los servicios correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarLabUsuario() {
            try {
                if (this.runUsuario == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un Rut",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.nombreUsuLab == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un nombre",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.apellidoUsuLab == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un apellido",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        RUN: this.runUsuario,
                        nombreUsuLab: this.nombreUsuario.toUpperCase(),
                        apellidoUsuLab: this.apellidoUsuario.toUpperCase()
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/PostLabUsuario",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text:
                                        "Usuario de Laboratorio Ingresado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpLabUsuario = false;
                                this.TraerLabUsuario();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible registrar el Servicio,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        ModificarLabUsuario() {
            try {
                if (this.runUsuario == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un Rut",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.nombreUsuLab == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un nombre",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.apellidoUsuLab == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un apellido",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id: this.idMod,
                        RUN: this.runUsuario,
                        nombreUsuLab: this.nombreUsuario.toUpperCase(),
                        apellidoUsuLab: this.apellidoUsuario.toUpperCase()
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/PutLabUsuario",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text:
                                        "Usuario de Laboratorio Modificado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpLabUsuarioMod = false;
                                this.TraerLabUsuario();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible modificar al usuario,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        RefreshToken() {
            try {
                let data = {
                    token: localStorage.getItem("token")
                };
                axios
                    .post(this.localVal + "/api/auth/RefreshToken", data)
                    .then(res => {
                        let tok = res.data;
                        if (tok == "") {
                        } else if (tok == false) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No se pudo refrescar su sesion, sera redirigido a el inicio de sesion",
                                color: "danger",
                                position: "top-right"
                            });
                            window.localStorage.clear();
                            window.localStorage.clear();
                            router.push("/pages/login");
                        } else {
                            localStorage.setItem("token", tok);
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.RefreshToken();
        setTimeout(() => {
            this.TraerLabUsuario();
            this.openLoadingColor();
        }, 2000);
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1000px;
}
</style>
