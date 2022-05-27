<template>
    <div>
        <vx-card title="Stock Insumo/Economato">
            <div>
                <vs-button
                    color="primary"
                    type="filled"
                    @click="PopUpListadoArticulos = true"
                    >Agregar Stock Insumo/Economato</vs-button
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
                                    content="Modificar Stock Insumo/Economato"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarStockMinMax(
                                            props.row.id,
                                            props.row.idBodega,
                                            props.row.idEstadoStock,
                                            props.row.CODART,
                                            props.row.NOMBRE,
                                            props.row.STOCK_MIN,
                                            props.row.STOCK_MAX,
                                            props.row.STOCK_CRI,
                                            props.row.UNIMEDBASE
                                        )
                                    "
                                ></plus-circle-icon>
                                <plus-circle-icon
                                    content="Desactivar Stock Insumo/Economato"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popDesactivarStockMinMax(props.row.id)
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
                classContent="AgregarStockInsumoEconomato"
                title="Agregar Stock Insumo/Economato"
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
                                    @click="popStockMinMaxVolver"
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
                                    >Agregar Stock Insumo/Economato</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="DesactivarStock"
                title="Desactivar Stock"
                :active.sync="popUpDesactivarStockMinMax"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row w-full">
                            <div class="vx-col w-1/2">
                                <vs-button
                                    @click="popUpDesactivarStockMinMax = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2">
                                <vs-button
                                    @click="DesactivarStock"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Desactivar Stock</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="stockModInsumoEconomato"
                title="Modificar Stock Insumo/Economato"
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
                                    >Modificar Stock Insumo/Economato</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="ListadoInsumoEconomato"
                title="Listado Articulos Insumo/Economato"
                :active.sync="PopUpListadoArticulos"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <vx-card>
                                <vue-good-table
                                    :columns="col"
                                    :rows="listaInsumoEconomato"
                                    :pagination-options="{
                                        enabled: true,
                                        perPage: 10
                                    }"
                                >
                                    <template
                                        slot="table-row"
                                        slot-scope="props"
                                    >
                                        <!-- Column: Name -->
                                        <span
                                            v-if="
                                                props.column.field ===
                                                    'fullName'
                                            "
                                            class="text-nowrap"
                                        >
                                        </span>
                                        <span
                                            v-else-if="
                                                props.column.field === 'action'
                                            "
                                        >
                                            <plus-circle-icon
                                                content="Asignar Insumo/Economato"
                                                v-tippy
                                                size="1.5x"
                                                class="custom-class"
                                                @click="
                                                    popAsignarInsumoEco(
                                                        props.row.NOMBRE,
                                                        props.row.CODART,
                                                        props.row.idEstado,
                                                        props.row.idBodega,
                                                        props.row.UNIMEDBASE
                                                    )
                                                "
                                            ></plus-circle-icon>
                                        </span>
                                        <!-- Column: Common -->
                                        <span v-else>
                                            {{
                                                props.formattedRow[
                                                    props.column.field
                                                ]
                                            }}
                                        </span>
                                    </template>
                                </vue-good-table>
                            </vx-card>
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
            PopUpListadoArticulos: false,
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
            //Template Columnas Listado
            col: [
                {
                    label: "Codigo de Barra",
                    field: "CODART_BARR",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Bodega",
                    field: "descripcionBodega",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Codigo Onu",
                    field: "CODART_ONU",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Codigo Articulo",
                    field: "CODART",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Nombre Medicamento",
                    field: "NOMBRE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Unidad de Medida",
                    field: "UNIMEDBASE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            columns: [
                {
                    label: "Bodega",
                    field: "descripcionBodega",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Estado",
                    field: "descripcionEstado",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Codigo Interno",
                    field: "CODART",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Nombre Articulo",
                    field: "NOMBRE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Stock Minimo",
                    field: "STOCK_MIN",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Stock Critico",
                    field: "STOCK_CRI",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Saldo",
                    field: "SALDO",
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
            listaArticulos: [],
            listaInsumoEconomato: []
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
                this.idBodega = 0;
                this.CodArt = 0;
                this.Nombre = "";
                this.UnidadMedida = "";
                this.stockMin = 0;
                this.stockCri = 0;
                this.seleccionBodega = {
                    id: 0,
                    descripcionBodega: ""
                };
                this.seleccionEstado = {
                    id: 0,
                    descripcionEstado: ""
                };
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popStockMinMaxVolver() {
            try {
                this.limpiarCampos();
                this.PopUpListadoArticulos = true;
                this.popUpStockMinMax = false;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarStockMinMax(
            id,
            idBodega,
            idEstadoStock,
            CODART,
            NOMBRE,
            STOCK_MIN,
            STOCK_MAX,
            STOCK_CRI,
            UNIMEDBASE
        ) {
            try {
                this.limpiarCampos();
                this.popUpStockMinMaxMod = true;
                this.idMod = id;
                this.CodArt = CODART;
                this.Nombre = NOMBRE;
                this.stockMin = STOCK_MIN;
                this.stockCri = STOCK_CRI;
                this.UnidadMedida = UNIMEDBASE;
                let c = this.listaEstado;

                c.forEach((value, index) => {
                    if (idEstadoStock == value.id) {
                        this.seleccionEstado.id = value.id;
                        this.seleccionEstado.descripcionEstado =
                            value.descripcionEstado;
                    }
                });

                c = [];

                this.idBodega = 0;

                c = this.listaBodega;

                c.forEach((value, index) => {
                    if (idBodega == value.id) {
                        this.seleccionBodega.id = value.id;
                        this.seleccionBodega.descripcionBodega =
                            value.descripcionBodega;
                    }
                });

                c = [];
            } catch (error) {
                console.log(error);
            }
        },
        popDesactivarStockMinMax(id) {
            try {
                this.limpiarCampos();
                this.popUpDesactivarStockMinMax = true;
                this.idMod = id;
            } catch (error) {
                console.log(error);
            }
        },
        popAsignarInsumoEco(NOMBRE, CODART, idEstado, idBodega, unimedbase) {
            try {
                this.limpiarCampos();
                this.PopUpListadoArticulos = false;
                this.popUpStockMinMax = true;
                this.CodArt = CODART;
                this.Nombre = NOMBRE;
                this.UnidadMedida = unimedbase;
                let c = this.listaEstado;

                c.forEach((value, index) => {
                    if (idEstado == value.id) {
                        this.seleccionEstado.id = value.id;
                        this.seleccionEstado.descripcionEstado =
                            value.descripcionEstado;
                    }
                });

                c = [];

                this.idBodega = 0;

                c = this.listaBodega;

                c.forEach((value, index) => {
                    if (idBodega == value.id) {
                        this.seleccionBodega.id = value.id;
                        this.seleccionBodega.descripcionBodega =
                            value.descripcionBodega;
                    }
                });

                c = [];
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
        TraerInsumoEconomato() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetInsumoEconomato", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaInsumoEconomato = res.data;
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
                if (this.stockMin == 0 || this.stockMin < 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un stock Minimo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.stockCri == 0 || this.stockCri < 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un stock Critico",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        idBodega: this.seleccionBodega.id,
                        idEstadoStock: 1,
                        CODART: this.CodArt,
                        NOMBRE: this.Nombre,
                        STOCK_MIN: this.stockMin,
                        STOCK_MAX: 0,
                        STOCK_CRI: this.stockCri,
                        UNIMEDBASE: this.UnidadMedida
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/PostStockMinMax",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text:
                                        "Stock Min/Max Ingresado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpStockMinMax = false;
                                this.TraerStockMinMax();
                                this.limpiarCampos();
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
                }
            } catch (error) {
                console.log(error);
            }
        },
        ModificarStockMinMax() {
            try {
                if (this.stockMin == 0 || this.stockMin < 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un stock Minimo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.stockCri == 0 || this.stockCri < 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un stock Critico",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id: this.idMod,
                        idBodega: this.seleccionBodega.id,
                        idEstadoStock: 1,
                        CODART: this.CodArt,
                        NOMBRE: this.Nombre,
                        STOCK_MIN: this.stockMin,
                        STOCK_MAX: 0,
                        STOCK_CRI: this.stockCri,
                        UNIMEDBASE: this.UnidadMedida
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/PutStockMinMax",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text:
                                        "Stock Min/Max Modificado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpStockMinMaxMod = false;
                                this.TraerStockMinMax();
                                this.limpiarCampos();
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
                }
            } catch (error) {
                console.log(error);
            }
        },
        DesactivarStock() {
            try {
                let data = {
                    id: this.idMod,
                    idEstadoStock: 2
                };

                const dat = data;

                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/PutDesactivarStockMinMax",
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
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text:
                                    "Stock Insumo/Economato Desactivado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpDesactivarStockMinMax = false;
                            this.TraerStockMinMax();
                            this.limpiarCampos();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible desactivar el Insumo/Economato,intentelo nuevamente",
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
        this.TraerInsumoEconomato();
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
