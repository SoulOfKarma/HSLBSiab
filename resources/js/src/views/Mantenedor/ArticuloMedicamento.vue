<template>
    <div>
        <vx-card title="Servicio">
            <div>
                <vs-button color="primary" type="filled" @click="popMedicamento"
                    >Agregar Medicamento</vs-button
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
                                    content="Modificar Servicio"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarServicio(
                                            props.row.id,
                                            props.row.descripcionServicio
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
                classContent="AgregarMedicamento"
                title="Agregar Medicamento"
                :active.sync="popUpMedicamento"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2">
                                <h6>
                                    Codigo de Barra
                                </h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Codigo Track</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Codigo Onu</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Codigo Interno</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Nombre Articulo</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Generico</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Categoria Farmacia</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Unidad Medida Base</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Concentracion</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Estado</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Activacion Fecha Venciminento</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Activacion Lote/Serie</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Laboratorio</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Cantidad Embalaje</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Bodega</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Zona</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Sector</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Ubicacion</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                            <div class="vx-col w-1/2">
                                <h6>Z Gen</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionServicio"
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <div class="vx-col w-1/2">
                                <vs-button
                                    @click="popUpMedicamento = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2">
                                <vs-button
                                    @click="AgregarMedicamento"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Agregar Medicamento</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="ServicioMod"
                title="Modificar Servicio"
                :active.sync="popUpServicioMod"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-full mt-5">
                                <h6>Servicio</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="descripcionServicio"
                                />
                            </div>
                        </div>
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="popUpServicioMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="ModificarServicio"
                                    color="warning"
                                    type="filled"
                                    class="w-full m-1"
                                    >Modificar Servicio</vs-button
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
            popUpMedicamento: false,
            popUpServicioMod: false,
            descripcionServicio: "",

            idMod: 0,
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "Servicio",
                    field: "descripcionServicio",
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
                this.descripcionServicio = "";
                this.idMod = 0;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popMedicamento() {
            try {
                this.popUpMedicamento = true;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarServicio(id, DesServicio) {
            try {
                this.limpiarCampos();
                this.popUpServicioMod = true;
                this.idMod = id;
                this.descripcionServicio = DesServicio;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD Servicios
        TraerServicio() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetServicios", {
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
        AgregarMedicamento() {
            try {
                let data = {
                    descripcionServicio: this.descripcionServicio
                    //CODART_BARR
                    //CODART_TRACK
                    //CODART_ONU
                    //CODART
                    //NOMBRE
                    //GENERICO
                    //CAT_FARMACIA
                    //UNIMEDBASE
                    //CONCENTRACION
                    //idEstado -> cambiar a biginteger en tabla
                    //ACT_FECVEN -> cambiar a boolean en tabla
                    //ACT_LOTE -> cambiar a boolean en tabla
                    //LABORATORIO
                    //CANTXEMB
                    //idBodega -> cambiar a biginteger en tabla
                    //idZona -> cambiar a biginteger en tabla
                    //SECTOR
                    //UBICACION
                    //ZGEN
                };

                const dat = data;

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PostServicios",
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
                                text: "Servicio Ingresado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpServicio = false;
                            this.TraerServicio();
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
            } catch (error) {
                console.log(error);
            }
        },
        ModificarServicio() {
            try {
                let data = {
                    id: this.idMod,
                    descripcionServicio: this.descripcionServicio
                };

                const dat = data;

                axios
                    .post(this.localVal + "/api/Mantenedor/PutServicio", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Servicio Modificado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpServicioMod = false;
                            this.TraerServicio();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible modificar el servicio,intentelo nuevamente",
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
        this.TraerServicio();
        this.openLoadingColor();
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1000px;
}
</style>
