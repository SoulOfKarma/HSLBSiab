<template>
    <div>
        <vx-card title="Usuarios">
            <div>
                <vs-button color="primary" type="filled" @click="popUsuarios"
                    >Agregar Nuevo Usuario</vs-button
                >
            </div>
            <br />
            <div>
                <vx-card>
                    <vue-good-table
                        :columns="columns"
                        :rows="rows"
                        :pagination-options="{
                            enabled: true,
                            perPage: 10
                        }"
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
                                    content="Modificar Usuario Autorizado"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarAuthUsuarios(props.row.id)
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
                classContent="Usuarios"
                title="Agregar Usuario"
                :active.sync="popUpUsuario"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Rut Usuario</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="rutUsuario"
                                    v-on:blur="formatear_run"
                                />
                                <span
                                    style="font-size: 10px; color: red; margin-left: 10px;"
                                    v-if="val_run"
                                    >Run incorrecto</span
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Razon Social</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="razonSocial"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Rut Usuario</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="rutUsuario"
                                    v-on:blur="formatear_run"
                                />
                                <span
                                    style="font-size: 10px; color: red; margin-left: 10px;"
                                    v-if="val_run"
                                    >Run incorrecto</span
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Telefono</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="razonSocial"
                                />
                            </div>
                        </div>

                        <div class="vx-row">
                            <div class="vx-col w-full md-5">
                                <vs-button
                                    @click="popUpUsuario = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                                <vs-button
                                    @click="AgregarUsuario"
                                    color="danger"
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
        </vx-card>
    </div>
</template>
<script>
import axios from "axios";
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { validate, clean, format } from "rut.js";
import { PlusCircleIcon } from "vue-feather-icons";
import Vue from "vue";
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
            popUpUsuario: false,
            popUpUsuarioMod: false,
            popUpUsuarioElim: false,
            rutUsuario: "",
            nombreUsuario: "",
            apellidoUsuario: "",
            idServicio: 0,
            idEstado: 0,
            fechaInicio: new Date(),
            fechaTermino: new Date(),
            val_run: false,
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
                    label: "Nombre",
                    field: "NOMBRES",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Apellido",
                    field: "APELLIDOS",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Servicio",
                    field: "NOMSER",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Fecha Inicio",
                    field: "FECINI",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Estado",
                    field: "ESTADO",
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
        formatear_run() {
            if (this.rutUsuario == "" || this.rutUsuario == null) {
                //console.log("Sin Rut");
                this.val_run = false;
            } else {
                this.rutUsuario = format(this.rutUsuario);
                this.val_run = !validate(this.rutUsuario);
            }
        },
        //PopUp
        popUsuarios() {
            try {
                this.popUpUsuario = true;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarAuthUsuarios() {
            try {
                this.popUpUsuarioMod = true;
            } catch (error) {
                console.log(error);
            }
        },
        popEliminarAuthUsuarios() {
            try {
                this.popUpUsuarioElim = true;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos para Agregar Datos
        TraerAuthUsuario() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetAuthUsuario", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.rows = res.data;
                        if (this.rows.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de los usuarios autorizados correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarUsuario() {
            try {
                let data = {
                    CODMOT: this.codAnulacion,
                    NOMMOT: this.motAnulacion
                };

                const dat = data;

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PostAuthUsuario",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
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
                                    "Usuario Autorizado Ingresado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpAnulacion = false;
                            this.TraerAnulacion();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar el Motivo Anulacion,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarUsuario() {
            try {
                let data = {
                    id: this.idMod,
                    CODMOT: this.codAnulacion,
                    NOMMOT: this.motAnulacion
                };

                const dat = data;

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PutAuthUsuario",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
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
                                    "Usuario Autorizado Modificado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpAnulacion = false;
                            this.TraerAnulacion();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar el Motivo Anulacion,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.TraerAuthUsuario();
        this.openLoadingColor();
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1000px;
}
</style>
