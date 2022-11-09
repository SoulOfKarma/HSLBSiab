<template>
    <div>
        <vx-card title="Anulacion">
            <div>
                <vs-button color="primary" type="filled" @click="popAnulacion"
                    >Agregar Anulacion</vs-button
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
                                    content="Modificar Anulacion"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarAnulacion(
                                            props.row.id,
                                            props.row.CODMOT,
                                            props.row.NOMMOT
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
                classContent="Anulacion"
                title="Agregar Anulacion"
                :active.sync="popUpAnulacion"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2">
                                <h6>Codigo Anulacion</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codAnulacion"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Motivo Anulacion</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="motAnulacion"
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <div class="vx-col w-1/2">
                                <vs-button
                                    @click="popUpAnulacion = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2">
                                <vs-button
                                    @click="AgregarAnulacion"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Agregar Anulacion</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="Anulacion"
                title="Modificar Anulacion"
                :active.sync="popUpAnulacionMod"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Codigo Anulacion</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="codAnulacion"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Motivo Anulacion</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="motAnulacion"
                                />
                            </div>
                        </div>
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="popUpAnulacionMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="ModificarAnulacion"
                                    color="warning"
                                    type="filled"
                                    class="w-full m-1"
                                    >Modificar Anulacion</vs-button
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
import Vue from "vue";
import VueTippy, { TippyComponent } from "vue-tippy";
import store from "../ScriptMenus/store.js";
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
            popUpAnulacion: false,
            popUpAnulacionMod: false,
            codAnulacion: "",
            motAnulacion: "",
            idMod: 0,
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "Codigo Anulacion",
                    field: "CODMOT",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Motivo Anulacion",
                    field: "NOMMOT",
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
        limpiarCampos() {
            try {
                this.codAnulacion = "";
                this.motAnulacion = "";
                this.idMod = 0;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popAnulacion() {
            try {
                this.popUpAnulacion = true;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarAnulacion(id, CodAnu, ModAnu) {
            try {
                this.limpiarCampos();
                this.popUpAnulacionMod = true;
                this.idMod = id;
                this.codAnulacion = CodAnu;
                this.motAnulacion = ModAnu;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD Anulacion
        TraerAnulacion() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetAnulacion", {
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
                                    "No hay datos o no se cargaron los datos de Motivo Anulacion correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarAnulacion() {
            try {
                if (this.codAnulacion == null || this.codAnulacion == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un codigo de anulacion",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.motAnulacion == null ||
                    this.motAnulacion == ""
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un motivo de anulacion",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        CODMOT: this.codAnulacion.toUpperCase(),
                        NOMMOT: this.motAnulacion.toUpperCase()
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/PostAnulacion",
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
                                        "Motivo Anulacion Ingresado Correctamente",
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
                }
            } catch (error) {
                console.log(error);
            }
        },
        ModificarAnulacion() {
            try {
                if (this.codAnulacion == null || this.codAnulacion == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un codigo de anulacion",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.motAnulacion == null ||
                    this.motAnulacion == ""
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un motivo de anulacion",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id: this.idMod,
                        CODMOT: this.codAnulacion.toUpperCase(),
                        NOMMOT: this.motAnulacion.toUpperCase()
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/PutAnulacion",
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
                                        "Motivo Anulacion Modificado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpAnulacionMod = false;
                                this.TraerAnulacion();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible modificar el Motivo Anulacion,intentelo nuevamente",
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
            this.TraerAnulacion();
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
