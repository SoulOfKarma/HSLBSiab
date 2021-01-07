<template>
    <div>
        <vs-row>
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card>
                    <vs-alert active="true" color="success">
                        Entrega Material - Agente:
                        {{ nombre }} - {{ run }}
                    </vs-alert>
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5"></div>
                        <div class="vx-col w-1/4 mt-5"></div>
                        <div class="vx-col w-1/4 mt-5">
                            <h6>Buscar</h6>
                            <vs-input
                                id="basicInput"
                                placeholder="Ej. 5"
                                v-model="searchTerm"
                                class="w-full"
                                @keyup.enter="buscarPorId()"
                            />
                        </div>
                    </div>

                    <vue-good-table
                        :columns="columns"
                        :rows="listadoInventario"
                        :search-options="{
                            enabled: true,
                            externalQuery: searchTerm
                        }"
                        :pagination-options="{
                            enabled: true,
                            perPage: pageLength
                        }"
                        @on-row-click="onRowClick"
                    ></vue-good-table>
                    <div class="vx-col w-full mt-5">
                        <vs-button
                            class="w-full"
                            color="primary"
                            type="filled"
                            @click="volver"
                            >Volver a la Pagina anterior</vs-button
                        >
                    </div>
                </vx-card>
                <br />
                <vx-card>
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.1 - Ubicacion</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder=""
                                v-model="
                                    materialSeleccion.descripcion_ubicacion
                                "
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.2 - Servicio</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder=""
                                v-model="materialSeleccion.descripcion_servicio"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.3 - Material</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder=""
                                v-model="materialSeleccion.descripcion_material"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.4 - Tipo Material</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder=""
                                v-model="
                                    materialSeleccion.descripcion_tipo_material
                                "
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.5 - Contenido</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder=""
                                v-model="
                                    materialSeleccion.descripcion_cantidad_especifica
                                "
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.6 - Medida</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder=""
                                v-model="materialSeleccion.descripcion_medidas"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.7 - Cantidad</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                placeholder="0"
                                v-model="materialSeleccion.material_cantidad"
                                @keypress="isNumber($event)"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.8 - Valor</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder=""
                                v-model="materialSeleccion.material_valor"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.9 - Documento</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder=""
                                v-model="
                                    materialSeleccion.descripcion_documento
                                "
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.10 - N° Documento</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder=""
                                v-model="materialSeleccion.n_documento"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-full mt-5">
                            <vs-button
                                class="w-full"
                                color="warning"
                                type="filled"
                                @click="AgregarItemListado"
                                >Agregar Item Al Listado</vs-button
                            >
                        </div>
                    </div>
                </vx-card>
                <vx-card>
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5"></div>
                        <div class="vx-col w-1/4 mt-5"></div>
                        <div class="vx-col w-1/4 mt-5">
                            <h6>Buscar</h6>
                            <vs-input
                                id="basicInput"
                                placeholder="Ej. 5"
                                v-model="busqueda"
                                class="w-full"
                                @keyup.enter="buscarPorIdAsignados()"
                            />
                        </div>
                    </div>

                    <vue-good-table
                        :columns="colAsigMat"
                        :rows="listadoAsignarInventario"
                        :search-options="{
                            enabled: true,
                            externalQuery: busqueda
                        }"
                        :pagination-options="{
                            enabled: true,
                            perPage: pageLength
                        }"
                        @on-row-click="rowClick"
                    ></vue-good-table>
                    <div class="vx-col w-full mt-5">
                        <vs-button
                            class="w-full"
                            color="success"
                            type="filled"
                            @click="AgregarItemListado"
                            >Asignar Materiales A la Solicitud</vs-button
                        >
                    </div>
                </vx-card>
                <br />
            </div>
        </vs-row>
    </div>
</template>
<script>
import axios from "axios";
import router from "@/router";
import { InfoIcon } from "vue-feather-icons";
import { PlusCircleIcon } from "vue-feather-icons";
import { Trash2Icon } from "vue-feather-icons";
import { UploadIcon } from "vue-feather-icons";
import { CornerDownRightIcon } from "vue-feather-icons";
import { ArchiveIcon } from "vue-feather-icons";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import Vue from "vue";
import Vuesax from "vuesax";
import vSelect from "vue-select";
import {
    BAvatar,
    BBadge,
    BPagination,
    BFormSelect,
    BDropdown,
    BDropdownItem
} from "bootstrap-vue";
import { BFormInput, BRow, BCol, BFormGroup } from "bootstrap-vue";
import { VueGoodTable } from "vue-good-table";
import VueGoodTablePlugin from "vue-good-table";

// import the styles
import "vue-good-table/dist/vue-good-table.css";

Vue.use(VueGoodTablePlugin);

Vue.use(Vuesax, {
    theme: {
        colors: {
            primary: "#5b3cc4",
            success: "rgb(23, 201, 100)",
            danger: "rgb(242, 19, 93)",
            warning: "rgb(255, 130, 0)",
            dark: "rgb(36, 33, 69)"
        }
    }
});
export default {
    components: {
        ArchiveIcon,
        InfoIcon,
        PlusCircleIcon,
        Trash2Icon,
        UploadIcon,
        CornerDownRightIcon,
        quillEditor,
        "v-select": vSelect,
        VueGoodTable,
        BAvatar,
        BBadge,
        BPagination,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BDropdown,
        BDropdownItem,
        BFormInput,
        BFormGroup,
        BRow,
        BCol
    },
    data() {
        return {
            pageLength: 10,
            dir: false,
            searchTerm: "",
            columns: [
                {
                    label: "ID",
                    field: "id",
                    type: "number"
                },
                {
                    label: "Ubicacion",
                    field: "descripcion_ubicacion"
                },
                {
                    label: "Servicio",
                    field: "descripcion_servicio"
                },
                {
                    label: "Material",
                    field: "descripcion_material"
                },
                {
                    label: "Tipo Material",
                    field: "descripcion_tipo_material"
                },
                {
                    label: "Contenido",
                    field: "descripcion_cantidad_especifica"
                },
                {
                    label: "Medida",
                    field: "descripcion_medidas"
                },
                {
                    label: "Cantidad",
                    field: "material_cantidad"
                },
                {
                    label: "Valor",
                    field: "material_valor"
                },
                {
                    label: "Tipo Documento",
                    field: "descripcion_documento"
                },
                {
                    label: "N° Documento",
                    field: "n_documento"
                }
            ],
            colAsigMat: [
                {
                    label: "ID",
                    field: "id",
                    type: "number"
                },
                {
                    label: "Ubicacion",
                    field: "descripcion_ubicacion"
                },
                {
                    label: "Servicio",
                    field: "descripcion_servicio"
                },
                {
                    label: "Material",
                    field: "descripcion_material"
                },
                {
                    label: "Tipo Material",
                    field: "descripcion_tipo_material"
                },
                {
                    label: "Contenido",
                    field: "descripcion_cantidad_especifica"
                },
                {
                    label: "Medida",
                    field: "descripcion_medidas"
                },
                {
                    label: "Cantidad",
                    field: "material_cantidad"
                },
                {
                    label: "Valor",
                    field: "material_valor"
                },
                {
                    label: "Tipo Documento",
                    field: "descripcion_documento"
                },
                {
                    label: "N° Documento",
                    field: "n_documento"
                }
            ],
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
            selected: [],
            descripcion_seguimiento: "",
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            run: sessionStorage.getItem("run"),
            materialSeleccion: {
                id: 0,
                descripcion_ubicacion: "",
                descripcion_servicio: "",
                descripcion_material: "",
                descripcion_tipo_material: "",
                descripcion_cantidad_especifica: "",
                descripcion_medidas: "",
                material_cantidad: 1,
                material_valor: 0,
                descripcion_documento: "",
                n_documento: ""
            },
            busqueda: "",
            valCantidad: 0,
            valCanFinal: 0,
            listadoInventario: [],
            listadoInventarioData: [],
            listadoTipoMaterial: [],
            listadoTipoMaterialData: [],
            listadoAsignarInventario: [],
            localVal: process.env.MIX_APP_URL
        };
    },
    methods: {
        buscarPorId() {
            try {
                let c = this.listadoTipoMaterialData;
                let b = [];
                let a = 0;
                c.forEach((value, index) => {
                    a = value.id;
                    if (a == this.searchTerm) {
                        b.push(value);
                    }
                });
                this.searchTerm = b[0].descripcion_tipo_material;
            } catch (error) {
                console.log("No Existe Material Activo Registrado");
            }
        },
        buscarPorIdAsignados() {
            try {
                let c = this.listadoTipoMaterialData;
                let b = [];
                let a = 0;
                c.forEach((value, index) => {
                    a = value.id;
                    if (a == this.busqueda) {
                        b.push(value);
                    }
                });
                this.busqueda = b[0].descripcion_tipo_material;
            } catch (error) {
                console.log("No Existe Material Activo Registrado");
            }
        },
        validarCantidad(evt) {
            if (this.valCantidad < this.materialSeleccion.material_cantidad) {
                this.materialSeleccion.material_cantidad = 1;
            } else {
                this.valCanFinal = this.materialSeleccion.material_cantidad;
            }
        },
        AgregarItemListado() {
            try {
                let d = 0;
                let c = this.listadoAsignarInventario;
                let b = [];
                let a = 0;
                let count = 0;
                if (c.length == [] || c.length == "" || c.length == 0) {
                    count = 0;
                } else {
                    count = c.length;
                }
                c.push([]);
                if (count == 0) {
                    b.push([this.materialSeleccion]);
                } else {
                    c.forEach((value, index) => {
                        if (count == index) {
                            b.push([this.materialSeleccion]);
                        } else {
                            b.push(value);
                        }
                    });
                }

                this.listadoAsignarInventario = b;
            } catch (error) {
                console.log(error);
            }
        },

        onRowClick(params) {
            this.materialSeleccion.id = params.row.id;
            this.materialSeleccion.descripcion_ubicacion =
                params.row.descripcion_ubicacion;
            this.materialSeleccion.descripcion_servicio =
                params.row.descripcion_servicio;
            this.materialSeleccion.descripcion_material =
                params.row.descripcion_material;
            this.materialSeleccion.descripcion_tipo_material =
                params.row.descripcion_tipo_material;
            this.materialSeleccion.descripcion_cantidad_especifica =
                params.row.descripcion_cantidad_especifica;
            this.materialSeleccion.descripcion_medidas =
                params.row.descripcion_medidas;
            this.materialSeleccion.material_cantidad =
                params.row.material_cantidad;
            this.materialSeleccion.material_valor = params.row.material_valor;
            this.materialSeleccion.descripcion_documento =
                params.row.descripcion_documento;
            this.materialSeleccion.n_documento = params.row.n_documento;
            this.valCantidad = params.row.material_cantidad;
        },
        rowClick(params) {
            this.materialSeleccion.id = params.row.id;
            this.materialSeleccion.descripcion_ubicacion =
                params.row.descripcion_ubicacion;
            this.materialSeleccion.descripcion_servicio =
                params.row.descripcion_servicio;
            this.materialSeleccion.descripcion_material =
                params.row.descripcion_material;
            this.materialSeleccion.descripcion_tipo_material =
                params.row.descripcion_tipo_material;
            this.materialSeleccion.descripcion_cantidad_especifica =
                params.row.descripcion_cantidad_especifica;
            this.materialSeleccion.descripcion_medidas =
                params.row.descripcion_medidas;
            this.materialSeleccion.material_cantidad =
                params.row.material_cantidad;
            this.materialSeleccion.material_valor = params.row.material_valor;
            this.materialSeleccion.descripcion_documento =
                params.row.descripcion_documento;
            this.materialSeleccion.n_documento = params.row.n_documento;
            this.valCantidad = params.row.material_cantidad;
        },
        isNumber: function(evt) {
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (
                (charCode > 31 &&
                    (charCode < 48 || charCode > 57) &&
                    charCode !== 46) ||
                this.valCantidad < this.materialSeleccion.material_cantidad
            ) {
                console.log(this.materialSeleccion.material_cantidad);
                evt.preventDefault();
                this.materialSeleccion.material_cantidad = 1;
            } else {
                this.valCanFinal = this.materialSeleccion.material_cantidad;
                return true;
            }

            /*  if (this.valCantidad < this.materialSeleccion.material_cantidad) {
                this.materialSeleccion.material_cantidad = 0;
            } else {
                this.valCanFinal = this.materialSeleccion.material_cantidad;
            } */
        },
        volver() {
            router.back();
        },

        cargarInventarioDisponible() {
            axios
                .get(this.localVal + "/api/Bodega/GetStock", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoInventario = res.data;
                    this.listadoInventarioData = res.data;
                });
        },
        cargarTipoMaterial() {
            axios
                .get(this.localVal + "/api/Bodega/GetTipoMaterial", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoTipoMaterial = res.data;
                    this.listadoTipoMaterialData = res.data;
                });
        }
    },
    created() {
        this.cargarInventarioDisponible();
        this.cargarTipoMaterial();
    }
};
</script>
