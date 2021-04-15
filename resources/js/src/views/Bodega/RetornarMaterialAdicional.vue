<template>
    <div>
        <vs-row>
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>Buscar</h6>
                            <vs-input
                                id="basicInput"
                                v-model="buscarPorNTicket"
                                class="w-full"
                                @keypress="onlyNumber($event)"
                            />
                            <br />
                            <vs-button
                                v-if="buscarT"
                                class="w-full"
                                color="primary"
                                type="filled"
                                @click="buscarByTicket"
                                >Busqueda Por N° Ticket</vs-button
                            >
                            <vs-button
                                v-else-if="nuevoT"
                                class="w-full"
                                color="primary"
                                type="filled"
                                @click="refrescarMenu"
                                >Nueva Busqueda</vs-button
                            >
                        </div>
                    </div>
                </vx-card>
            </div>

            <div
                class="vx-col md:w-1/1 w-full mb-base"
                v-show="validarBusqueda"
            >
                <vx-card>
                    <vs-alert active="true" color="success">
                        Devolucion Material - Agente:
                        {{ nombre }} - {{ run }}
                    </vs-alert>

                    <vue-good-table
                        :columns="columns"
                        :rows="listadoInventario"
                        :search-options="{
                            enabled: true
                            //externalQuery: searchTerm
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
                            <h6>1.2 - Material</h6>
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
                            <h6>1.3 - Medida</h6>
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
                            <h6>1.4 - Cantidad</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                placeholder="0"
                                v-model="material_cantidad"
                                @keypress="isNumber($event)"
                                @keyup="validarCantidad()"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.5 - Valor</h6>
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
                            <h6>1.6 - Documento</h6>
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
                            <h6>1.7 - N° Documento</h6>
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
                                @click="AddList()"
                                >Agregar Item Al Listado</vs-button
                            ><br />
                        </div>
                    </div>
                </vx-card>
                <vx-card>
                    <!-- @on-row-click="rowClick" -->
                    <vue-good-table
                        :columns="colAsigMat"
                        :rows="listadoDevolucionInventario"
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
                        <vs-button
                            class="w-full"
                            color="success"
                            type="filled"
                            @click="DevolucionMaterialOT()"
                            >Devolver Materiales A la Solicitud</vs-button
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
var _ = require("lodash");
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
                    label: "Material",
                    field: "descripcion_material"
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
                    label: "Material",
                    field: "descripcion_material"
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
                descripcion_material: "",
                descripcion_medidas: "",
                material_cantidad: 1,
                material_valor: 0,
                descripcion_documento: "",
                n_documento: ""
            },
            id: 0,
            descripcion_ubicacion: "",
            descripcion_material: "",
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
            /*             listadoTipoMaterial: [],
            listadoTipoMaterialData: [], */
            listadoDevolucionInventario: [],
            listadoDevolucionInventarioData: [],
            externalVal: process.env.MIX_APP_URL_EXTERNA,
            localVal: process.env.MIX_APP_URL,
            val: 0,
            validador: false,
            dataParam: [],
            buscarPorNTicket: 0,
            validarBusqueda: false,
            buscarT: true,
            nuevoT: false,
            listadoInventarioParaDevolucion: [],
            listadoInventarioParaDevolucionData: [],
            valorTotalItem: 0
        };
    },
    methods: {
        limpiar() {
            this.id = 0;
            this.descripcion_ubicacion = "";
            this.descripcion_material = "";
            this.descripcion_medidas = "";
            this.material_cantidad = 1;
            this.material_valor = 0;
            this.descripcion_documento = "";
            this.n_documento = "";
        },
        onlyNumber: function(evt) {
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
        buscarByTicket() {
            try {
                let obj = {
                    idTicket: this.buscarPorNTicket
                };
                axios
                    .post(
                        this.localVal + "/api/Bodega/PostStockDevolucion",
                        obj,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoInventario = res.data;
                        this.listadoInventarioData = res.data;
                        this.validarBusqueda = true;
                        this.buscarT = false;
                        this.nuevoT = true;
                    });
            } catch (error) {
                console.log("Error al realizar la busqueda");
            }
        },
        refrescarMenu() {
            try {
                this.buscarT = true;
                this.nuevoT = false;
                this.validarBusqueda = false;
                this.listadoInventario = [];
                this.listadoInventarioData = [];
                this.listadoDevolucionInventario = [];
                this.listadoDevolucionInventarioData = [];
            } catch (error) {
                console.log("Error al vaciar listados");
            }
        },
        quitarItem(id) {
            try {
                var d = this.listadoInventario;
                let e = [];
                let f = 0;
                let c = this.listadoDevolucionInventario;
                let b = [];
                let a = 0;
                let vars = 0;

                c.forEach((value, index) => {
                    a = id;
                    if (a === value.id) {
                        vars = parseInt(value.material_cantidad);
                    }
                });
                d.forEach((value, index) => {
                    f = id;
                    if (f === value.id) {
                        d.splice(index, 1);
                        value.material_cantidad =
                            parseInt(value.material_cantidad) + parseInt(vars);

                        d.splice(index, 0, value);
                    }
                });
                c.forEach((value, index) => {
                    a = id;
                    if (a === value.id) {
                        this.listadoDevolucionInventario.splice(index, 1);
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        validarCantidad() {
            let c = this.listadoInventario;
            let b = [];
            let a = 0;
            c.forEach((value, index) => {
                a = this.id;
                if (a === value.id) {
                    if (
                        this.material_cantidad <= 0 ||
                        this.material_cantidad > value.material_cantidad
                    ) {
                        this.$vs.notify({
                            time: 3000,
                            title: "Error de Cantidad",
                            text:
                                "La cantidad es Menor o Superior de las existencias actuales",
                            color: "danger",
                            position: "top-right"
                        });
                        this.validador = false;
                    } else {
                        this.validador = true;
                    }
                }
            });
        },

        AddList() {
            try {
                //var d = Array.from(this.listadoInventarioData);
                //let d = Object.assign({}, this.listadoInventarioData);
                //let clonar = _.clone(this.listadoInventarioData);

                if (this.validador) {
                    var d = this.listadoInventarioData;
                    let e = [];
                    let f = 0;
                    let c = this.listadoDevolucionInventario;
                    let b = [];
                    let a = 0;
                    this.val = 0;

                    let obj = {
                        id: this.id,
                        descripcion_ubicacion: this.descripcion_ubicacion,
                        descripcion_material: this.descripcion_material,
                        descripcion_medidas: this.descripcion_medidas,
                        material_cantidad: this.material_cantidad,
                        material_valor: this.material_valor,
                        descripcion_documento: this.descripcion_documento,
                        n_documento: this.n_documento,
                        id_material_inventario: this.dataParam.id,
                        id_cant_esp: this.dataParam.id_cant_esp,
                        id_cubiculo: this.dataParam.id_cubiculo,
                        id_documento: this.dataParam.id_documento,
                        id_estados: this.dataParam.id_estados,
                        id_material_ing: this.dataParam.id_material_ing,
                        id_material_medida: this.dataParam.id_material_medida,
                        id_servicios: this.dataParam.id_servicios,
                        id_ubicaciones: this.dataParam.id_ubicaciones,
                        material_cantidad_calculada: this.dataParam
                            .material_cantidad_calculada,
                        m_cant: this.material_cantidad,
                        v_total: this.valorTotalItem
                    };

                    if (c.length > 0) {
                        c.forEach((value, index) => {
                            a = obj.id;
                            if (a === value.id) {
                                this.val = value.material_cantidad;
                            }
                        });
                    }

                    if (c.length === 0) {
                        d.forEach((value, index) => {
                            f = obj.id;
                            if (f === value.id) {
                                d.splice(index, 1);

                                value.material_cantidad =
                                    value.material_cantidad -
                                    obj.material_cantidad;
                                d.splice(index, 0, value);
                            }
                        });
                    } else {
                        d.forEach((value, index) => {
                            f = obj.id;
                            if (f === value.id) {
                                d.splice(index, 1);
                                value.material_cantidad =
                                    parseInt(value.material_cantidad) +
                                    parseInt(this.val);
                                value.material_cantidad =
                                    value.material_cantidad -
                                    obj.material_cantidad;
                                d.splice(index, 0, value);
                            }
                        });
                    }

                    this.listadoInventario = d;

                    if (c.length > 0) {
                        c.forEach((value, index) => {
                            a = obj.id;
                            if (a === value.id) {
                                this.listadoDevolucionInventario.splice(index);
                            }
                        });
                    }

                    this.listadoDevolucionInventario.push(obj);
                    this.validador = false;
                } else {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error de Cantidad",
                        text:
                            "La cantidad es Menor o Superior de las existencias actuales",
                        color: "danger",
                        position: "top-right"
                    });
                }
            } catch (error) {
                console.log(error);
            }
        },
        DevolucionMaterialOT() {
            try {
                //Calculo A modificar
                let idUser = sessionStorage.getItem("id");
                let c = JSON.parse(
                    JSON.stringify(this.listadoDevolucionInventario)
                );
                let d = JSON.parse(JSON.stringify(this.listadoInventario));

                let b = [];
                let f = [];
                let list = "";
                c.forEach((value, index) => {
                    d.forEach((val, ind) => {
                        if (value.id == val.id) {
                            value.material_cantidad =
                                parseInt(value.v_total) -
                                parseInt(value.m_cant);
                            val.m_cant = value.m_cant;
                            value.idOT = this.buscarPorNTicket;
                            val.idOT = this.buscarPorNTicket;
                            b.push(val);
                            f.push(value);
                        }
                    });
                });

                c = [];
                d = [];
                c = JSON.parse(
                    JSON.stringify(this.listadoInventarioParaDevolucion)
                );
                d = b;
                b = [];
                c.forEach((value, index) => {
                    d.forEach((val, ind) => {
                        if (value.id == val.id_material_inventario) {
                            value.material_cantidad =
                                parseInt(value.material_cantidad) +
                                parseInt(val.m_cant);
                            b.push(value);
                        }
                    });
                });

                const inventario = b;
                const data = f;

                axios
                    .all([
                        axios.post(
                            this.localVal + "/api/Bodega/PutAsignarMaterial",
                            inventario,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        ),
                        axios.post(
                            this.localVal +
                                "/api/Bodega/PutHistorialMateriales",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        ),
                        axios.post(
                            this.localVal + "/api/Bodega/PutRetornoMateriales",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                    ])
                    .then(
                        axios.spread((res1, res2, res3, res4) => {
                            if (res1.data == true) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Material Asignado a la OT",
                                    text: "Se retornara al menu anterior",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.listadoDevolucionInventario = [];
                                this.limpiar();
                                this.refrescarMenu();
                                this.seguimientoExternoOT(list);
                            } else {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error Al Asignar Material a la OT",
                                    text:
                                        "Intente Nuevamente o Consulte con el Administrador",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        })
                    );
            } catch (error) {
                console.log("Error al guardar data");
            }
        },
        seguimientoExternoOT(list) {
            try {
                let idExt = this.$route.params.id;
                let uidExt = this.$route.params.uuid;

                let data = {
                    uuid: uidExt,
                    id_user: 74,
                    id_solicitud: idExt,
                    descripcionSeguimiento: list
                };

                const inventario = data;

                axios
                    .post(
                        this.externalVal + "/api/seguimientoExternoBodega",
                        inventario,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` +
                                    sessionStorage.getItem("token_externo")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoAsignarInventario = [];

                        //router.back();
                    });
            } catch (error) {
                console.log(error);
            }
        },
        onRowClick(params) {
            this.id = params.row.id;
            this.descripcion_ubicacion = params.row.descripcion_ubicacion;
            this.descripcion_material = params.row.descripcion_material;
            this.descripcion_medidas = params.row.descripcion_medidas;
            this.material_cantidad = params.row.material_cantidad;
            this.valorTotalItem = params.row.material_cantidad;
            this.material_valor = params.row.material_valor;
            this.descripcion_documento = params.row.descripcion_documento;
            this.n_documento = params.row.n_documento;
            this.valCantidad = params.row.material_cantidad;

            this.dataParam = params.row;
        },
        rowClick(params) {
            this.id = params.row.id;
            this.descripcion_ubicacion = params.row.descripcion_ubicacion;
            this.descripcion_material = params.row.descripcion_material;
            this.descripcion_medidas = params.row.descripcion_medidas;
            this.material_cantidad = params.row.material_cantidad;
            this.material_valor = params.row.material_valor;
            this.descripcion_documento = params.row.descripcion_documento;
            this.n_documento = params.row.n_documento;
            this.valCantidad = params.row.material_cantidad;
            this.dataParam = params.row;
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
                    this.listadoInventarioParaDevolucion = res.data;
                    this.listadoInventarioParaDevolucionData = JSON.parse(
                        JSON.stringify(this.listadoInventarioParaDevolucion)
                    );
                });
        }
    },
    created() {
        this.cargarInventarioDisponible();
    }
};
</script>
