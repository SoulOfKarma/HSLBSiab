<template>
    <div>
        <vs-row>
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card>
                    <vs-alert active="true" color="success">
                        Historial Material - Agente:
                        {{ nombre }} - {{ run }}
                    </vs-alert>
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.1 - Ubicacion</h6>
                            <br />
                            <v-select
                                v-model="seleccionUbicacion"
                                placeholder="Ubicacion"
                                class="w-full select-large"
                                label="descripcion_ubicacion"
                                :options="listadoUbicacion"
                                @input="filtroSegunUbicacion"
                            >
                            </v-select>
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.2 Seleccione Cubiculo</h6>
                            <br />
                            <v-select
                                taggable
                                v-model="seleccionCubiculo"
                                placeholder="Cubiculo"
                                class="w-full select-large"
                                label="descripcion_cubiculo"
                                :options="listadoCubiculo"
                                @input="popNuevoCubiculo"
                            >
                            </v-select>
                        </div>
                        <div class="vx-col w-1/5 mt-5">
                            <h6>1.3 - Material</h6>
                            <br />
                            <v-select
                                taggable
                                v-model="seleccionMaterial"
                                placeholder="Material"
                                class="w-full select-large"
                                label="descripcion_material"
                                :options="listadoMaterial"
                                @input="filtroSegunMaterial"
                            ></v-select>
                            <br />
                        </div>

                        <div class="vx-col w-1/5 mt-5">
                            <h6>1.4 - Cantidad</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="cantidad"
                                @input="CalcTotal"
                                :step="0.5"
                                @keypress="isNumber($event)"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/5 mt-5">
                            <h6>1.5 Ingrese Cantidad Minima</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="cantidadMinima"
                                @input="CalcTotal"
                                :step="0.5"
                                @keypress="isNumber($event)"
                            />
                        </div>
                        <div class="vx-col w-1/5 mt-5">
                            <h6>1.6 - Medida</h6>
                            <br />
                            <v-select
                                v-model="seleccionMedidas"
                                placeholder="Medidas"
                                class="w-full select-large"
                                label="descripcion_medidas"
                                :options="listadoMedidas"
                            />
                        </div>
                        <div class="vx-col w-1/5 mt-5">
                            <h6>1.7 - Valor</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="valor"
                                @input="valorTotal"
                                :step="0.5"
                                @keypress="isNumber($event)"
                            ></vs-input>
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>Total Segun Medida.</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                v-model="total"
                                :step="0.5"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>Total Valor.</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                v-model="totalValor"
                                :step="0.5"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.8 - Documento</h6>
                            <br />
                            <v-select
                                v-model="seleccionDocumento"
                                placeholder="Documento"
                                class="w-full select-large"
                                label="descripcion_documento"
                                :options="listadoDocumentoAsociado"
                            ></v-select>
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.9 - N° Documento</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="ndocumento"
                            ></vs-input>
                            <br />
                        </div>
                        <div class="vx-col w-full mt-5">
                            <h6>2.1 - Razon del Cambio</h6>
                            <br />
                            <quill-editor
                                class="w-full"
                                v-model="descripcion_seguimiento"
                                :options="editorOption"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
                        </div>

                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                class="w-full"
                                color="primary"
                                type="filled"
                                @click="volver"
                                >Volver</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                class="w-full"
                                color="warning"
                                type="filled"
                                @click="guardarCambios"
                                >Guardar</vs-button
                            >
                        </div>
                    </div>
                </vx-card>
            </div>
        </vs-row>
        <vs-popup
            classContent="pop-Crear"
            title="Guardar Nuevo Material?"
            :active.sync="popActiveMaterial"
        >
            <vs-input class="inputx mb-3" v-model="desMaterial" hidden />
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="guardarMaterial(desMaterial)"
                        >
                            Guardar
                        </vs-button>
                    </div>
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            class="w-full m-2"
                            @click="popActiveMaterial = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
        <vs-popup
            classContent="pop-CrearTipo"
            title="Guardar Nuevo Cubiculo?"
            :active.sync="popActiveCubiculo"
        >
            <vs-input class="inputx mb-3" v-model="desCubiculo" hidden />
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="guardarCubiculo(desCubiculo)"
                        >
                            Guardar
                        </vs-button>
                    </div>
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            class="w-full m-2"
                            @click="popActiveCubiculo = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
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
export default {
    components: {
        ArchiveIcon,
        InfoIcon,
        PlusCircleIcon,
        Trash2Icon,
        UploadIcon,
        CornerDownRightIcon,
        quillEditor,
        "v-select": vSelect
    },
    data: () => ({
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
        descripcion_seguimiento: "",
        nombre:
            sessionStorage.getItem("nombre") +
            " " +
            sessionStorage.getItem("apellido"),
        run: sessionStorage.getItem("run"),
        materialSeleccion: {
            id: 0,
            id_ubicaciones: "",
            id_material_ing: "",
            id_material_tipo: "",
            id_material_medida: "",
            material_cantidad: "",
            material_valor: "",
            id_documento: "",
            n_documento: "",
            descripcion_seguimiento: ""
        },
        seleccionUbicacion: {
            id: 0,
            descripcion_ubicacion: "Seleccione Ubicacion"
        },
        seleccionMedidas: {
            id: 8,
            descripcion_medidas: "UN"
        },
        seleccionMaterial: {
            id: 0,
            descripcion_material: "Seleccione Material"
        },
        seleccionCubiculo: {
            id: 0,
            descripcion_cubiculo: "Seleccione Cubiculo"
        },
        seleccionDocumento: {
            id: 0,
            descripcion_documento: "Seleccione Documento"
        },
        listadoCubiculo: [],
        listadoUbicacion: [],
        listadoUbicacionData: [],
        listadoMedidas: [],
        listadoMedidasData: [],
        listadoMaterial: [],
        listadoMaterialData: [],
        listadoTipoMaterial: [],
        listadoTipoMaterialData: [],
        listadoDocumentoAsociado: [],
        cantidad: 0,
        cantidadMinima: 0,
        valor: 0,
        total: 0,
        totalMaterial: 0,
        totalValor: 0,
        desMaterial: "",
        desCubiculo: "",
        idMaterial: 0,
        medida: "cc",
        ndocumento: "",
        localVal: process.env.MIX_APP_URL,
        popActiveMaterial: false,
        popActiveCubiculo: false
    }),
    computed: {},
    methods: {
        limpiar() {
            this.seleccionMedidas = {
                id: 8,
                descripcion_medidas: "UN"
            };
            this.seleccionMaterial = {
                id: 0,
                descripcion_material: "Seleccione Material"
            };
            this.seleccionTipoMaterial = {
                id: 0,
                descripcion_tipo_material: "Selecione Tipo Material"
            };
            /* this.seleccionCantEsp = {
                id: 3,
                descripcion_cantidad_especifica: "N/A"
            }; */
            this.seleccionCubiculo = {
                id: 0,
                descripcion_cubiculo: "Seleccione Cubiculo"
            };
            this.cantidad = 0;
            this.valor = 0;
            this.total = 0;
            this.totalMaterial = 0;
            this.totalValor = 0;
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
        volver() {
            router.back();
        },
        guardarCambios() {
            if (
                this.seleccionUbicacion.id == 0 ||
                this.seleccionUbicacion.id == null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: " Ubicacion no seleccionada o con error",
                    text: "Seleccionela Nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionMaterial.id == 0 ||
                this.seleccionMaterial.id == null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: " Material no seleccionado o con error",
                    text: "Seleccionela nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionMedidas.id == 0 ||
                this.seleccionMedidas.id == null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: " Medida no seleccionada o con error",
                    text: "Seleccionela nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            } else if (this.cantidad <= 0 || this.cantidad == null) {
                this.$vs.notify({
                    time: 3000,
                    title: " Campo cantidad vacio",
                    text: "Ingrese cantidad para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.cantidadMinima <= 0 ||
                this.cantidadMinima == null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: "Campo Cantidad Minima Vacio",
                    text: "Ingrese cantidad para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else if (this.valor <= 0 || this.valor == null) {
                this.$vs.notify({
                    time: 3000,
                    title: " Campo valor vacio",
                    text: "Ingrese valor para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionDocumento.id == 0 ||
                this.seleccionDocumento == null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: " Tipo Documento no seleccionado o con error",
                    text: "Seleccione nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            } else if (this.ndocumento == "" || this.ndocumento == null) {
                this.$vs.notify({
                    time: 3000,
                    title: "Campo N° Documento Vacio ",
                    text: "Ingrese el N° de documento",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.descripcion_seguimiento == "" ||
                this.descripcion_seguimiento == null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: " Campo Razon de cambio vacio",
                    text: "Ingrese la razon para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else {
                let id = this.$route.params.id;
                let data = {
                    id: id,
                    id_ubicaciones: this.seleccionUbicacion.id,
                    id_cubiculo: this.seleccionCubiculo.id,
                    id_material_ing: this.seleccionMaterial.id,
                    id_material_medida: this.seleccionMedidas.id,
                    material_cantidad: this.cantidad,
                    material_cantidad_minima: this.cantidadMinima,
                    material_valor: this.valor,
                    material_cantidad_calculada: this.totalMaterial,
                    id_documento: this.seleccionDocumento.id,
                    n_documento: this.ndocumento
                };

                const inventario = data;

                axios
                    .post(
                        this.localVal + "/api/Bodega/PutInventario",
                        inventario,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        if (res.data == true) {
                            this.$vs.notify({
                                time: 3000,
                                title: "Inventario Modificado Correctamente",
                                text: "Se vaciaran campos",
                                color: "success",
                                position: "top-right"
                            });
                            this.limpiar();
                        } else {
                            this.$vs.notify({
                                time: 3000,
                                title: "Error Al Modificar Inventario",
                                text:
                                    "Intente Nuevamente o Consulte con el Administrador",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            }
        },
        filtroSegunUbicacion() {
            if (
                this.seleccionUbicacion == null ||
                this.seleccionUbicacion == 0
            ) {
                this.listadoUbicacion = this.listadoUbicacionData;
                this.listadoServicio = this.listadoServicioData;
            } else {
                var idGen = this.seleccionUbicacion.id;
                let c = this.listadoServicioData;
                let b = [];
                let a = 0;
                c.forEach((value, index) => {
                    a = value.id_material_ubicacion;
                    if (a == idGen) {
                        b.push(value);
                    }
                });
                this.listadoServicio = b;
            }
        },
        popNuevoCubiculo() {
            try {
                if (
                    this.seleccionCubiculo.id == null ||
                    this.seleccionCubiculo.id == 0
                ) {
                    if (
                        this.seleccionCubiculo.descripcion_cubiculo ===
                            undefined ||
                        this.seleccionCubiculo.descripcion_cubiculo === "" ||
                        this.seleccionCubiculo.descripcion_cubiculo === null
                    ) {
                        this.desCubiculo = this.seleccionCubiculo;
                        this.popActiveCubiculo = true;
                    } else {
                        this.desCubiculo = this.seleccionCubiculo.descripcion_cubiculo;
                        this.popActiveCubiculo = true;
                    }
                }
            } catch (error) {
                console.log("Error al tratar de filtrar el cubiculo");
            }
        },
        guardarCubiculo(desCub) {
            try {
                let data = {
                    descripcion_cubiculo: desCub
                };

                axios
                    .post(this.localVal + "/api/Bodega/PostCubiculo", data, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        if (res.data == true) {
                            this.$vs.notify({
                                time: 3000,
                                title: "Cubiculo Agregado Correctamente",
                                text: "Se Recargara Listado",
                                color: "success",
                                position: "top-right"
                            });
                            this.cargarCubiculos();
                            this.popActiveCubiculo = false;
                            this.seleccionCubiculo = {
                                id: 0,
                                descripcion_cubiculo: ""
                            };
                        } else {
                            this.$vs.notify({
                                time: 3000,
                                title: "Error Al Guardar cubiculo",
                                text:
                                    "Intente Nuevamente o Consulte con el Administrador",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log("Hubo un error al tratar de guardar el Cubiculo");
            }
        },
        filtroSegunMaterial() {
            try {
                if (
                    this.seleccionMaterial.id == 0 ||
                    this.seleccionMaterial.id == null
                ) {
                    if (
                        this.seleccionMaterial.descripcion_material ===
                            undefined ||
                        this.seleccionMaterial.descripcion_material === "" ||
                        this.seleccionMaterial.descripcion_material === null
                    ) {
                        this.desMaterial = this.seleccionMaterial;
                        this.popActiveMaterial = true;
                    } else {
                        this.desMaterial = this.seleccionMaterial.descripcion_material;
                        this.popActiveMaterial = true;
                    }
                }
            } catch (error) {
                console.log("Error al filtrar Materiales");
            }
        },
        cargarUbicaciones() {
            axios
                .get(this.localVal + "/api/Bodega/GetUbicaciones", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoUbicacion = res.data;
                    this.listadoUbicacionData = res.data;
                });
        },
        cargarMedidas() {
            axios
                .get(this.localVal + "/api/Bodega/GetMedidasFiltradas", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoMedidas = res.data;
                    this.listadoMedidasData = res.data;
                });
        },
        cargarMaterial() {
            axios
                .get(this.localVal + "/api/Bodega/GetMaterial", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoMaterial = res.data;
                    this.listadoMaterialData = res.data;
                });
        },
        cargarDocumentoAsociado() {
            axios
                .get(this.localVal + "/api/Bodega/GetDocumentos", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoDocumentoAsociado = res.data;
                });
        },
        guardarMaterial(valor) {
            let material = {
                descripcion_material: valor
            };

            axios
                .post(this.localVal + "/api/Bodega/PostMaterial", material, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    if (res.data == true) {
                        this.$vs.notify({
                            time: 3000,
                            title: " Material Agregado Correctamente",
                            text: "Se Recargara Listado",
                            color: "success",
                            position: "top-right"
                        });
                        this.cargarMaterial();
                        this.popActiveMaterial = false;
                    } else {
                        this.$vs.notify({
                            time: 3000,
                            title: "Error Al Guardar Tipo Material",
                            text:
                                "Intente Nuevamente o Consulte con el Administrador",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
        },
        CalcTotal() {
            try {
                if (
                    this.seleccionMaterial.id == 0 ||
                    this.seleccionMaterial.id == null
                ) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error ",
                        text:
                            "Debe Seleccionar Algun Material para calcular la cantidad",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.seleccionMedidas.id == 0 ||
                    this.seleccionMedidas.id == null
                ) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error ",
                        text: "Alguna Medida",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    if (this.seleccionMedidas.id == 1) {
                        console.log("CC");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let res = this.cantidad * 0.001;
                                this.total = res + " Litros";
                                this.totalMaterial = res;
                            }
                        } catch (error) {
                            console.log(
                                "Hubo un error al caculos los centimetros cubicos"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 2) {
                        console.log("MM");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let res = this.cantidad * 0.001;
                                this.total = res + " Metros";
                                this.totalMaterial = res;
                            }
                        } catch (error) {
                            console.log(
                                "Hubo un error al intentar calcular los milimetros a Metros"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 3) {
                        console.log("PULG");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let res = this.cantidad * 0.0254;
                                this.total = res.toFixed(2) + " Metros";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log(
                                "Fallo al calcular las pulgadas a metros"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 4) {
                        console.log("CM");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let res = this.cantidad * 0.01;
                                this.total = res + " Metros";
                                this.totalMaterial = res;
                            }
                        } catch (error) {
                            console.log(
                                "Error al intentar calcular los centimetros a Metros"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 5) {
                        console.log("KG");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                this.total = this.cantidad + " Kilos";
                                this.totalMaterial = this.cantidad;
                            }
                        } catch (error) {
                            console.log(
                                "Error al intentar calcular los kilogramos"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 6) {
                        console.log("GR");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let res = this.cantidad * 0.001;
                                this.total = res + " Kilos";
                                this.totalMaterial = res;
                            }
                        } catch (error) {
                            console.log(
                                "Error al intentar calcular los gramos a kilos"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 7) {
                        console.log("ROLLO");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                this.total = this.cantidad + " Metros";
                                this.totalMaterial = this.cantidad;
                            }
                        } catch (error) {
                            console.log(
                                "Error al intentar calcular rollo a metro"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 8) {
                        console.log("UN");
                        this.total = this.cantidad + " Unidades";
                        this.totalMaterial = parseFloat(this.cantidad).toFixed(
                            2
                        );
                    } else if (this.seleccionMedidas.id == 9) {
                        try {
                            console.log("TIRA");
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                let res = this.cantidad * 6;
                                this.total = res + " Metros";
                                this.totalMaterial = Math.round(res.toFixed(2));
                            } else {
                                let res = this.cantidad * 6;
                                this.total = res + " Metros";
                                let valor = res;

                                valor = Math.round(valor);

                                this.totalMaterial = Math.round(valor);
                            }
                        } catch (error) {
                            console.log(
                                "Error al tratar de calcular tira a metros"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 10) {
                        console.log("SACO");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                this.total = this.cantidad + " Saco";
                                this.totalMaterial = this.cantidad;
                            }
                        } catch (error) {
                            console.log(
                                "Error al tratar de calcular los sacos"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 11) {
                        console.log("ML");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let res = this.cantidad * 0.001;
                                this.total = res + " Litros";
                                this.totalMaterial = res;
                            }
                        } catch (error) {
                            console.log(
                                "Error al calcular mililitros a litros"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 12) {
                        console.log("M2");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                let res = this.cantidad;
                                this.total = res + " Metros Cuadrados";
                                this.totalMaterial = res;
                            } else {
                                let res = this.cantidad.toFixed(2);
                                this.total = res + " Metros Cuadrados";
                                this.totalMaterial = res;
                            }
                        } catch (error) {
                            console.log(
                                "Error al tratar de calcular los metros cuadrados"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 13) {
                        console.log("M3");
                    } else if (this.seleccionMedidas.id == 14) {
                        console.log("LT");

                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                this.total = this.cantidad + " Litros";
                                this.totalMaterial = this.cantidad;
                            }
                        } catch (error) {
                            console.log(
                                "Error al tratar de calcular los litros"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 15) {
                        console.log("TAMBOR");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                this.total = this.cantidad + " Tambores";
                                this.totalMaterial = this.cantidad;
                            }
                        } catch (error) {
                            console.log(
                                "Error al tratar de calcular los tambores"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 16) {
                        console.log("BOLSA");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                this.total = this.cantidad + " Bolsas";
                                this.totalMaterial = this.cantidad;
                            }
                        } catch (error) {
                            console.log("Error al tratar de calcular la bolsa");
                        }
                    } else if (this.seleccionMedidas.id == 17) {
                        console.log("GALON");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                let res = this.cantidad * 3.78541;

                                this.total = res.toFixed(2) + " Litros";
                                this.totalMaterial = res.toFixed(2);
                            } else {
                                let res = this.cantidad * 3.78541;
                                this.total = res.toFixed(2) + " Litros";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log(
                                "Error al tratar de calcular los galones a litros"
                            );
                        }
                    } else if (this.seleccionMedidas.id == 18) {
                        console.log("CAJA");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                this.total = this.cantidad + " Cajas";
                                this.totalMaterial = this.cantidad;
                            }
                        } catch (error) {
                            console.log("Error al calcular las cajas");
                        }
                    } else if (this.seleccionMedidas.id == 20) {
                        console.log("PLANCHA");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                this.total = this.cantidad + " Plancha";
                                this.totalMaterial = this.cantidad;
                            }
                        } catch (error) {
                            console.log("Error al calcular las planchas");
                        }
                    } else if (this.seleccionMedidas.id == 21) {
                        console.log("METRO");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);

                            this.total = this.cantidad + " Metros";
                            this.totalMaterial = parseFloat(
                                this.cantidad
                            ).toFixed(2);
                        } catch (error) {
                            console.log("Error al calcular los metros");
                        }
                    } else if (this.seleccionMedidas.id == 22) {
                        console.log("PAR");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            this.total = this.cantidad + " Pares";
                            this.totalMaterial = parseFloat(
                                this.cantidad
                            ).toFixed(2);
                        } catch (error) {
                            console.log("Error al calcular los pares");
                        }
                    } else if (this.seleccionMedidas.id == 23) {
                        console.log("CARRETE");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                let res = parseFloat(this.cantidad);

                                this.total = res.toFixed(2) + " Carretes";
                                this.totalMaterial = res.toFixed(2);
                            } else {
                                let res = parseFloat(this.cantidad);

                                this.total = res.toFixed(2) + " Carretes";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Error al calcular los carretes");
                        }
                    } else if (this.seleccionMedidas.id == 24) {
                        console.log("TINETA");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(Number.parseFloat(this.cantidad))
                            ) {
                                let res = this.cantidad * 15.14164;

                                this.total = res.toFixed(2) + " Litros";
                                this.totalMaterial = res.toFixed(2);
                            } else {
                                let res = this.cantidad * 15.14164;
                                this.total = res.toFixed(2) + " Litros";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log(
                                "Error al calcular la cantidad de tinetas a ingresar"
                            );
                        }
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        cargarMaterialEspecifico() {
            let id = this.$route.params.id;
            axios
                .get(this.localVal + `/api/Bodega/TraerMaterial/${id}`, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    let data = res.data;
                    this.cargarDataEspecifica(data);
                })
                .catch(error => console.log(error));
        },
        valorTotal() {
            let total = this.valor * this.cantidad;
            this.totalValor = total;
        },
        cargarDataEspecifica(listado) {
            setTimeout(() => {
                var idGen = listado[0].id_ubicaciones;
                let c = this.listadoUbicacionData;
                let b = [];
                let a = 0;
                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGen) {
                        b.push(value);
                    }
                });

                this.seleccionUbicacion.id = b[0].id;
                this.seleccionUbicacion.descripcion_ubicacion =
                    b[0].descripcion_ubicacion;

                idGen = listado[0].id_material_ing;

                c = this.listadoMaterialData;
                b = [];
                a = 0;
                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGen) {
                        b.push(value);
                    }
                });

                this.seleccionMaterial.id = listado[0].id_material_ing;
                this.seleccionMaterial.descripcion_material =
                    b[0].descripcion_material;

                idGen = listado[0].id_cubiculo;

                c = this.listadoCubiculo;
                b = [];
                a = 0;
                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGen) {
                        b.push(value);
                    }
                });

                this.seleccionCubiculo.id = b[0].id;
                this.seleccionCubiculo.descripcion_cubiculo =
                    b[0].descripcion_cubiculo;

                idGen = listado[0].id_material_medida;
                c = this.listadoMedidasData;
                b = [];
                a = 0;
                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGen) {
                        b.push(value);
                    }
                });
                this.seleccionMedidas.id = b[0].id;
                this.seleccionMedidas.descripcion_medidas =
                    b[0].descripcion_medidas;

                this.cantidad = listado[0].material_cantidad;
                this.cantidadMinima = listado[0].material_cantidad_minima;
                this.valor = listado[0].material_valor;
                this.ndocumento = listado[0].n_documento;

                idGen = listado[0].id_documento;
                c = this.listadoDocumentoAsociado;
                b = [];
                a = 0;
                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGen) {
                        b.push(value);
                    }
                });
                this.seleccionDocumento.id = b[0].id;
                this.seleccionDocumento.descripcion_documento =
                    b[0].descripcion_documento;
            }, 2000);
        },
        cargarCubiculos() {
            axios
                .get(this.localVal + "/api/Bodega/GetCubiculos", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoCubiculo = res.data;
                });
        }
    },
    created() {
        this.cargarUbicaciones();
        /*         this.cargarServicios(); */
        this.cargarMedidas();
        this.cargarMaterial();
        /*         this.cargarCantidadEspecifica(); */
        this.cargarDocumentoAsociado();
        this.cargarMaterialEspecifico();
        this.cargarCubiculos();
    }
};
</script>
