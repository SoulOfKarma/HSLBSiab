<template>
    <div>
        <vx-card title="Stock Min/Max">
            <div>
                <vs-button color="primary" type="filled" @click="popStockMinMax"
                    >Agregar Stock Min/Max</vs-button
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
                                    content="Modificar Stock Min/Max"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarStockMinMax(
                                            props.row.id,
                                            props.row.descripcionEstado
                                        )
                                    "
                                ></plus-circle-icon>
                                <plus-circle-icon
                                    content="Desactivar Stock Min/Max"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popDesactivarStockMinMax(
                                            props.row.id,
                                            props.row.descripcionEstado
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
                classContent="AgregarStockMinMax"
                title="Agregar Stock Min/Max"
                :active.sync="popUpStockMinMax"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Bodega</h6>
                                <br />
                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    disabled
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Codigo Interno</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="CodArt"
                                    disabled
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre Articulo</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="Nombre"
                                    disabled
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Unidad Medida Base</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="UnidadMedida"
                                    disabled
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Stock Minimo</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="stockMin"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Stock Critico</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="stockCri"
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <div class="vx-col w-1/2">
                                <vs-button
                                    @click="popUpStockMinMax = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2">
                                <vs-button
                                    @click="AgregarStockMinMax"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Agregar Stock Min/Max</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="stockMod"
                title="Modificar Stock Min/Max"
                :active.sync="popUpStockMinMaxMod"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Bodega</h6>
                                <br />
                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    disabled
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Codigo Interno</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="CodArt"
                                    disabled
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre Articulo</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="Nombre"
                                    disabled
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Unidad Medida Base</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="UnidadMedida"
                                    disabled
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Stock Minimo</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="stockMin"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Stock Critico</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="stockCri"
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <div class="vx-col w-1/2">
                                <vs-button
                                    @click="popUpStockMinMaxMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2">
                                <vs-button
                                    @click="ModificarStockMinMax"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Modificar Stock Min/Max</vs-button
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
            popUpStockMinMax: false,
            popUpStockMinMaxMod: false,
            popUpDesactivarStockMinMax: false,
            descripcionEstado: "",
            idMod: 0,
            idBodega: 0,
            CodArt: 0,
            Nombre: "",
            UnidadMedida: "",
            stockMin: 0,
            stockCri: 0,
            seleccionBodega: {
                id: 0,
                descripcionBodega: ""
            },
            seleccionEstado: {
                id: 0,
                descripcionEstado: ""
            },
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "Estado",
                    field: "descripcionEstado",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            //Datos Listado
            rows: [],
            listaEstado: [],
            listaBodega: [],
            listaArticulos: []
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
                this.descripcionEstado = "";
                this.idMod = 0;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popStockMinMax() {
            try {
                this.popUpStockMinMax = true;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarStockMinMax(id, DesEstado) {
            try {
                this.limpiarCampos();
                this.popUpStockMinMaxMod = true;
                this.idMod = id;
                this.descripcionEstado = DesEstado;
            } catch (error) {
                console.log(error);
            }
        },
        popDesactivarStockMinMax(id, DesEstado) {
            try {
                this.limpiarCampos();
                this.popUpDesactivarStockMinMax = true;
                this.idMod = id;
                this.descripcionEstado = DesEstado;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD Servicios
        TraerEstado() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetEstado", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaEstado = res.data;
                        if (this.listaEstado.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Estado correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerBodega() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetBodega", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaBodega = res.data;
                        if (this.listaBodega.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de las Bodegas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerStockMinMax() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetStockMinMax", {
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
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarStockMinMax() {
            try {
                let data = {
                    descripcionEstado: this.descripcionEstado
                };

                const dat = data;

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PostStockMinMax",
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
                                text: "Stock Min/Max Ingresado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpStockMinMax = false;
                            this.TraerStockMinMax();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar el Stock Min/Max,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        ModificarStockMinMax() {
            try {
                let data = {
                    id: this.idMod,
                    descripcionEstado: this.descripcionEstado
                };

                const dat = data;

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PutStockMinMax",
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
                                text: "Stock Min/Max Modificado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpStockMinMaxMod = false;
                            this.TraerStockMinMax();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible modificar el Stock Min/Max,intentelo nuevamente",
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
        this.TraerStockMinMax();
        this.TraerEstado();
        this.TraerBodega();
        this.openLoadingColor();
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1000px;
}
</style>
