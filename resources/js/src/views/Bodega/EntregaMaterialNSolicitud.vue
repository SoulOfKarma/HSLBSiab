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
                                v-model="descripcion_ubicacion"
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
                                v-model="descripcion_servicio"
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
                                v-model="descripcion_material"
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
                                v-model="descripcion_tipo_material"
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
                                v-model="descripcion_cantidad_especifica"
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
                                v-model="descripcion_medidas"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.7 - Cantidad</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                placeholder="0"
                                v-model="material_cantidad"
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
                                v-model="material_valor"
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
                                v-model="descripcion_documento"
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
                                v-model="n_documento"
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
                            ><br />
                        </div>
                    </div>
                </vx-card>
                <vx-card>
                    <vue-good-table
                        :columns="colAsigMat"
                        :rows="listadoAsignarInventario"
                        @on-row-click="rowClick"
                    >
                        <template slot="table-row" slot-scope="props">
                            <!-- Column: Name -->
                            <span
                                v-if="props.column.field === 'fullName'"
                                class="text-nowrap"
                            >
                            </span>

                            <!-- Column: Action -->
                            <span v-else-if="props.column.field === 'action'">
                                <trash-2-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="quitarItem(props.row.id)"
                                ></trash-2-icon>
                            </span>

                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template></vue-good-table
                    >
                    <div class="vx-col w-full mt-5">
                        <vs-button class="w-full" color="success" type="filled"
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
                },
                {
                    label: "Opciones",
                    field: "action"
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
            n_documento: "",
            busqueda: "",
            valCantidad: 0,
            valCanFinal: 0,
            listadoInventario: [],
            listadoInventarioData: [],
            listadoTipoMaterial: [],
            listadoTipoMaterialData: [],
            listadoAsignarInventario: [],
            listadoAsignarInventarioData: [],
            localVal: process.env.MIX_APP_URL
        };
    },
    methods: {
        quitarItem(id) {
            console.log(id);
            console.log(this.listadoInventarioData);
        },
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
                let d = this.listadoInventarioData;
                let e = [];
                let f = 0;
                let c = this.listadoAsignarInventario;
                let b = [];
                let a = 0;
                let obj = {
                    id: this.id,
                    descripcion_ubicacion: this.descripcion_ubicacion,
                    descripcion_servicio: this.descripcion_servicio,
                    descripcion_material: this.descripcion_material,
                    descripcion_tipo_material: this.descripcion_tipo_material,
                    descripcion_cantidad_especifica: this
                        .descripcion_cantidad_especifica,
                    descripcion_medidas: this.descripcion_medidas,
                    material_cantidad: this.material_cantidad,
                    material_valor: this.material_valor,
                    descripcion_documento: this.descripcion_documento,
                    n_documento: this.n_documento
                };
                d.forEach((value, index) => {
                    f = obj.id;
                    if (f == value.id) {
                        this.listadoInventario.splice(index, 1);
                        console.log(d);
                        value.material_cantidad =
                            value.material_cantidad - obj.material_cantidad;
                        this.listadoInventario.splice(index, 0, value);
                    }
                });

                if (c.length > 0) {
                    c.forEach((value, index) => {
                        a = obj.id;
                        if (a == value.id) {
                            this.listadoAsignarInventario.splice(index);
                        }
                    });
                }

                this.listadoAsignarInventario.push(obj);
            } catch (error) {
                console.log(error);
            }
        },

        onRowClick(params) {
            this.id = params.row.id;
            this.descripcion_ubicacion = params.row.descripcion_ubicacion;
            this.descripcion_servicio = params.row.descripcion_servicio;
            this.descripcion_material = params.row.descripcion_material;
            this.descripcion_tipo_material =
                params.row.descripcion_tipo_material;
            this.descripcion_cantidad_especifica =
                params.row.descripcion_cantidad_especifica;
            this.descripcion_medidas = params.row.descripcion_medidas;
            this.material_cantidad = params.row.material_cantidad;
            this.material_valor = params.row.material_valor;
            this.descripcion_documento = params.row.descripcion_documento;
            this.n_documento = params.row.n_documento;
            this.valCantidad = params.row.material_cantidad;
        },
        rowClick(params) {
            this.id = params.row.id;
            this.descripcion_ubicacion = params.row.descripcion_ubicacion;
            this.descripcion_servicio = params.row.descripcion_servicio;
            this.descripcion_material = params.row.descripcion_material;
            this.descripcion_tipo_material =
                params.row.descripcion_tipo_material;
            this.descripcion_cantidad_especifica =
                params.row.descripcion_cantidad_especifica;
            this.descripcion_medidas = params.row.descripcion_medidas;
            this.material_cantidad = params.row.material_cantidad;
            this.material_valor = params.row.material_valor;
            this.descripcion_documento = params.row.descripcion_documento;
            this.n_documento = params.row.n_documento;
            this.valCantidad = params.row.material_cantidad;
        },
        isNumber: function(evt) {
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (
                (charCode > 31 &&
                    (charCode < 48 || charCode > 57) &&
                    charCode !== 46) ||
                this.valCantidad < this.material_cantidad
            ) {
                evt.preventDefault();
                this.material_cantidad = 1;
            } else {
                this.valCanFinal = this.material_cantidad;
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
