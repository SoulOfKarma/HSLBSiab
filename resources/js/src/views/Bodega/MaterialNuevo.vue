<template>
    <div>
        <vs-row>
            <div
                class="router-header flex flex-wrap items-center mb-8"
                style="margin-left:10px;"
            >
                <div
                    class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                >
                    <h2 class="mb-1">Ingreso de Material Nuevo</h2>
                </div>
                <div class="vx-breadcrumb ml-4 md:block hidden">
                    <div
                        class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                    >
                        <h3 class="mb-1">
                            Agente:
                            <p>{{ nombre }} - {{ run }}</p>
                        </h3>
                    </div>
                </div>
            </div>
            <vs-alert
                color="primary"
                icon="new_releases"
                active="true"
                style="margin-bottom: 10px;"
            >
                <p>Recuerda que todos los campos son obligatorios!</p>
            </vs-alert>
            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Ingreso de Material Nuevo">
                    <div class="vx-row mb-4">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.1 Seleccione Ubicacion</h6>
                            <br />
                            <v-select
                                taggable
                                v-model="seleccionUbicacion"
                                placeholder="Ubicacion"
                                class="w-full select-large"
                                label="descripcion_ubicacion"
                                :options="listadoUbicacion"
                                @input="filtroSegunUbicacion"
                            >
                            </v-select>
                        </div>
                        <!-- <div class="vx-col w-1/3 mt-5">
                            <h6>1.2 Seleccione Servicio</h6>
                            <br />
                            <v-select
                                taggable
                                v-model="seleccionServicio"
                                placeholder="Servicio"
                                class="w-full select-large"
                                label="descripcion_servicio"
                                :options="listadoServicio"
                                @input="filtroSegunServicio"
                            >
                            </v-select>
                        </div> -->
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
                    </div>
                    <div class="vx-row mb-4">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.3 Seleccione Material a Ingresar</h6>
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
                        </div>
                        <div class="vx-col w-1/6 mt-5">
                            <h6>1.4 Ingrese Cantidad</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="cantidad"
                                @input="CalcTotal"
                                :step="0.5"
                                @keypress="isNumber($event)"
                            />
                        </div>
                        <div class="vx-col w-1/7 mt-5">
                            <h6>Tipo Medida</h6>
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
                            <h6>Total Segun Medida.</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                v-model="total"
                                :step="0.5"
                            />
                        </div>
                        <!-- <div class="vx-col w-1/3 mt-5">
                            <h6>1.5 Ingrese Contenido</h6>
                            <br />
                            <v-select
                                taggable
                                v-model="seleccionCantEsp"
                                placeholder="Cantidad Esp."
                                class="w-full select-large"
                                label="descripcion_cantidad_especifica"
                                :options="listadoCantEsp"
                                @input="crearValidarCantEsp"
                            ></v-select>
                        </div> -->
                    </div>
                    <div class="vx-row mb-4">
                        <div class="vx-col w-1/4 mt-5">
                            <h6>1.5 Ingrese Valor del Material</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="valor"
                                @input="valorTotal"
                                :step="0.5"
                                @keypress="isNumber($event)"
                            ></vs-input>
                        </div>
                        <div class="vx-col w-1/4 mt-5">
                            <h6>Total Valor.</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                v-model="totalValor"
                                :step="0.5"
                            />
                        </div>
                        <div class="vx-col w-1/4 mt-5">
                            <h6>1.6 Seleccione Tipo Documento</h6>
                            <br />
                            <v-select
                                v-model="seleccionDocumento"
                                placeholder="Documento"
                                class="w-full select-large"
                                label="descripcion_documento"
                                :options="listadoDocumentoAsociado"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/4 mt-5">
                            <h6>1.7 Ingrese N° Documento</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="ndocumento"
                            ></vs-input>
                        </div>
                    </div>
                    <div class="vx-row mb-4"></div>
                    <div class="vx-row mb-4">
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                class="fixedHeight w-full"
                                @click="volver"
                                color="primary"
                                >Volver</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                class="fixedHeight w-full"
                                @click="guardarMaterialNuevo"
                                color="success"
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
        <!-- <vs-popup
            classContent="pop-CrearTipo"
            title="Guardar Nuevo Servicio?"
            :active.sync="popActiveServicio"
        >
            <vs-input class="inputx mb-3" v-model="desServicio" hidden />
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full">
                        <h6>Seleccione Ubicacion</h6>
                        <br />
                        <v-select
                            v-model="seleccionUbicacionG"
                            placeholder="Ubicacion"
                            class="w-full select-large"
                            label="descripcion_ubicacion"
                            :options="listadoUbicacion"
                        >
                        </v-select>
                        <br />
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="guardarServicio(desServicio)"
                        >
                            Guardar
                        </vs-button>
                    </div>
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            class="w-full m-2"
                            @click="popActiveServicio = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup> -->
        <vs-popup
            classContent="pop-CrearTipo"
            title="Guardar Nuevo Ubicacion?"
            :active.sync="popActiveUbicacion"
        >
            <vs-input class="inputx mb-3" v-model="desUbicacion" hidden />
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="guardarUbicacion(desUbicacion)"
                        >
                            Guardar
                        </vs-button>
                    </div>
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            class="w-full m-2"
                            @click="popActiveUbicacion = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
        <!-- <vs-popup
            classContent="pop-CrearTipo"
            title="Guardar Cantidad Especifica?"
            :active.sync="popActiveCantidadEsp"
        >
            <vs-input class="inputx mb-3" v-model="desCantEsp" hidden />
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="guardarCantidadEspecifica(desCantEsp)"
                        >
                            Guardar
                        </vs-button>
                    </div>
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            class="w-full m-2"
                            @click="popActiveCantidadEsp = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup> -->
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
        "v-select": vSelect
    },
    data() {
        return {
            seleccionCubiculo: {
                id: 0,
                descripcion_cubiculo: "Seleccione Cubiculo"
            },
            seleccionUbicacion: {
                id: 0,
                descripcion_ubicacion: "Seleccione Ubicacion"
            },
            seleccionUbicacionG: {
                id: 0,
                descripcion_ubicacion: "Seleccione Ubicacion"
            },
            /*             seleccionServicio: {
                id: 0,
                descripcion_servicio: "Seleccione Servicio"
            }, */
            seleccionMedidas: {
                id: 8,
                descripcion_medidas: "UN"
            },
            seleccionMaterial: {
                id: 0,
                descripcion_material: "Seleccione Material"
            },
            /*             seleccionCantEsp: {
                id: 0,
                descripcion_cantidad_especifica: "400"
            }, */
            seleccionDocumento: {
                id: 0,
                descripcion_documento: "Seleccione Documento"
            },
            listadoCubiculo: [],
            listadoUbicacion: [],
            listadoUbicacionData: [],
            /*             listadoServicio: [],
            listadoServicioData: [], */
            listadoMedidas: [],
            listadoMedidasData: [],
            listadoMaterial: [],
            listadoMaterialData: [],
            /*             listadoCantEsp: [],
            listadoCantEspData: [], */
            listadoDocumentoAsociado: [],
            cantidad: 0,
            valor: 0,
            total: 0,
            totalMaterial: 0,
            totalValor: 0,
            desMaterial: "",
            desCubiculo: "",
            /*             desServicio: "", */
            desUbicacion: "",
            /*             desCantEsp: "", */
            idMaterial: 0,
            medida: "cc",
            ndocumento: "",
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            run: sessionStorage.getItem("run"),
            localVal: process.env.MIX_APP_URL,
            popActiveMaterial: false,
            popActiveCubiculo: false,
            /*             popActiveCantidadEsp: false,
            popActiveServicio: false, */
            popActiveUbicacion: false
        };
    },
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
        /* filtroSegunServicio() {
            try {
                if (
                    this.seleccionServicio.id == null ||
                    this.seleccionServicio.id == 0
                ) {
                    if (
                        this.seleccionServicio.descripcion_servicio ===
                            undefined ||
                        this.seleccionServicio === "" ||
                        this.seleccionServicio === null
                    ) {
                        this.desServicio = this.seleccionServicio;
                        this.popActiveServicio = true;
                    } else {
                        this.desServicio = this.seleccionServicio.descripcion_servicio;
                        this.popActiveServicio = true;
                    }
                } else {
                    let idGen = this.seleccionServicio.id_material_ubicacion;
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
                }
            } catch (error) {}
        }, */
        //Guardar Servicio
        /* guardarServicio(desSer) {
            try {
                let data = {
                    id_material_ubicacion: this.seleccionUbicacionG.id,
                    descripcion_servicio: desSer
                };

                axios
                    .post(this.localVal + "/api/Bodega/PostServicio", data, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        if (res.data == true) {
                            this.$vs.notify({
                                time: 3000,
                                title: "Servicio Agregado Correctamente",
                                text: "Se Recargara Listado",
                                color: "success",
                                position: "top-right"
                            });
                            this.cargarServicios();
                            this.popActiveServicio = false;
                            this.seleccionServicio = {
                                id: 0,
                                descripcion_servicio: ""
                            };
                            this.seleccionUbicacion = {
                                id: 0,
                                descripcion_ubicacion: ""
                            };
                        } else {
                            this.$vs.notify({
                                time: 3000,
                                title: "Error Al Guardar Servicio",
                                text:
                                    "Intente Nuevamente o Consulte con el Administrador",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log("Hubo un error al tratar de guardar el servicio");
            }
        }, */
        filtroSegunUbicacion() {
            try {
                if (
                    this.seleccionUbicacion.id == null ||
                    this.seleccionUbicacion.id == 0
                ) {
                    if (
                        this.seleccionUbicacion.descripcion_ubicacion ===
                            undefined ||
                        this.seleccionUbicacion.descripcion_ubicacion === "" ||
                        this.seleccionUbicacion.descripcion_ubicacion === null
                    ) {
                        this.desUbicacion = this.seleccionUbicacion;
                        this.popActiveUbicacion = true;
                    } else {
                        this.desUbicacion = this.seleccionUbicacion.descripcion_ubicacion;
                        this.popActiveUbicacion = true;
                    }
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
            } catch (error) {
                console.log(
                    "Hubo un error al tratar de abrir el Pop de nueva ubicacion"
                );
            }
        },
        guardarUbicacion(desUbi) {
            try {
                let data = {
                    descripcion_ubicacion: desUbi
                };

                axios
                    .post(this.localVal + "/api/Bodega/PostUbicacion", data, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        if (res.data == true) {
                            this.$vs.notify({
                                time: 3000,
                                title: "Ubicacion Agregada Correctamente",
                                text: "Se Recargara Listado",
                                color: "success",
                                position: "top-right"
                            });
                            this.cargarUbicaciones();
                            this.popActiveUbicacion = false;
                            this.seleccionUbicacion = {
                                id: 0,
                                descripcion_ubicacion: ""
                            };
                        } else {
                            this.$vs.notify({
                                time: 3000,
                                title: "Error Al Guardar Ubicacion",
                                text:
                                    "Intente Nuevamente o Consulte con el Administrador",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log("Hubo un error al tratar de guardar la ubicacion");
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
                } /* else {
                    var idGen = this.seleccionCubiculo.id;
                    let c = this.listadoCubiculo;
                    let b = [];
                    let a = 0;
                    c.forEach((value, index) => {
                        a = value.id;
                        if (a == idGen) {
                            b.push(value);
                        }
                    });
                    this.seleccionCubiculo = b;
                } */
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
        CrearValidarTipoMaterial() {
            try {
                if (
                    this.seleccionTipoMaterial.id == 0 ||
                    this.seleccionTipoMaterial.id == null
                ) {
                    if (
                        this.seleccionTipoMaterial.descripcion_tipo_material ===
                            undefined ||
                        this.seleccionTipoMaterial.descripcion_tipo_material ===
                            null ||
                        this.seleccionTipoMaterial.descripcion_tipo_material ==
                            ""
                    ) {
                        if (
                            this.seleccionMaterial.id == 0 ||
                            this.seleccionMaterial.id == null
                        ) {
                            this.$vs.notify({
                                time: 3000,
                                title: "Debe Seleccionar Material",
                                text:
                                    "Debe estar Seleccionado Para asociar el nuevo tipo de material",
                                color: "warning",
                                position: "top-right"
                            });
                        } else {
                            console.log(this.seleccionMaterial);
                            this.idMaterial = this.seleccionMaterial.id;
                            this.desTipoMaterial = this.seleccionTipoMaterial;
                            this.popActiveTMaterial = true;
                        }
                    } else {
                        if (
                            this.seleccionMaterial.id == 0 ||
                            this.seleccionMaterial.id == null
                        ) {
                            this.$vs.notify({
                                time: 3000,
                                title: "Debe Seleccionar Material",
                                text:
                                    "Debe estar Seleccionado Para asociar el nuevo tipo de material",
                                color: "warning",
                                position: "top-right"
                            });
                        } else {
                            console.log(this.seleccionMaterial.id);
                            this.idMaterial = this.seleccionMaterial.id;
                            this.desTipoMaterial = this.seleccionTipoMaterial.descripcion_tipo_material;
                            this.popActiveTMaterial = true;
                        }
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        /*  crearValidarCantEsp() {
            try {
                if (
                    this.seleccionCantEsp.id == 0 ||
                    this.seleccionCantEsp.id == null
                ) {
                    if (
                        this.seleccionCantEsp
                            .descripcion_cantidad_especifica === undefined ||
                        this.seleccionCantEsp
                            .descripcion_cantidad_especifica === null ||
                        this.seleccionCantEsp.descripcion_cantidad_especifica ==
                            ""
                    ) {
                        this.desCantEsp = this.seleccionCantEsp;
                        this.popActiveCantidadEsp = true;
                    } else {
                        this.desCantEsp = this.seleccionCantEsp.descripcion_cantidad_especifica;
                        this.popActiveCantidadEsp = true;
                    }
                }
            } catch (error) {
                console.log(error);
            }
        }, */
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
        /*  cargarServicios() {
            axios
                .get(this.localVal + "/api/Bodega/GetServicios", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoServicio = res.data;
                    this.listadoServicioData = res.data;
                });
        }, */
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
        /* cargarCantidadEspecifica() {
            axios
                .get(this.localVal + "/api/Bodega/GetCantEsp", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoCantEsp = res.data;
                    this.listadoCantEspData = res.data;
                });
        }, */
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
                        this.seleccionMedidas = {
                            id: 8,
                            descripcion_medidas: "UN"
                        };
                        this.seleccionMaterial = {
                            id: 0,
                            descripcion_material: "Seleccione Material"
                        };
                    } else {
                        this.$vs.notify({
                            time: 3000,
                            title: "Error Al Guardar Material",
                            text:
                                "Intente Nuevamente o Consulte con el Administrador",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
        },
        /* guardarCantidadEspecifica(valor) {
            let material = {
                descripcion_cantidad_especifica: valor
            };

            axios
                .post(this.localVal + "/api/Bodega/PostCantEsp", material, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    if (res.data == true) {
                        this.$vs.notify({
                            time: 3000,
                            title: "Cantidad Especifica Agregada Correctamente",
                            text: "Se Recargara Listado",
                            color: "success",
                            position: "top-right"
                        });
                        this.cargarCantidadEspecifica();
                        this.seleccionCantEsp = {
                            id: 0,
                            descripcion_cantidad_especifica:
                                "Seleccione Cantidad Especifica"
                        };
                        this.popActiveCantidadEsp = false;
                    } else {
                        this.$vs.notify({
                            time: 3000,
                            title: "Error Al Guardar Material",
                            text:
                                "Intente Nuevamente o Consulte con el Administrador",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
        }, */
        guardarMaterialNuevo() {
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
                        text: "Debe seleccionar Alguna Medida",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.seleccionUbicacion.id == 0 ||
                    this.seleccionUbicacion.id == null
                ) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error ",
                        text: "Debe seleccionar alguna ubicacion",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.seleccionCubiculo.id == 0 ||
                    this.seleccionCubiculo.id == null
                ) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error ",
                        text: "Debe seleccionar algun Cubiculo",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id_ubicaciones: this.seleccionUbicacion.id,
                        //id_servicios: this.seleccionServicio.id,
                        id_cubiculo: this.seleccionCubiculo.id,
                        id_material_ing: this.seleccionMaterial.id,
                        //id_cant_esp: this.seleccionCantEsp.id,
                        id_material_medida: this.seleccionMedidas.id,
                        material_cantidad: this.cantidad,
                        material_valor: this.valor,
                        material_cantidad_calculada: this.totalMaterial,
                        id_documento: this.seleccionDocumento.id,
                        n_documento: this.ndocumento,
                        id_estados: 5
                    };

                    const inventario = data;

                    axios
                        .post(
                            this.localVal + "/api/Bodega/PostInventario",
                            inventario,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            if (res.data == true) {
                                this.$vs.notify({
                                    time: 3000,
                                    title:
                                        "Inventario Registrado Correctamente",
                                    text: "Se vaciaran campos",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.limpiar();
                            } else {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error Al Guardar Inventario",
                                    text:
                                        "Intente Nuevamente o Consulte con el Administrador",
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
        volver() {
            router.back();
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
        valorTotal() {
            let total = this.valor * this.cantidad;
            this.totalValor = Math.round(total);
        }
    },
    created() {
        this.cargarUbicaciones();
        //.cargarServicios();
        this.cargarMedidas();
        this.cargarMaterial();
        //this.cargarCantidadEspecifica();
        this.cargarDocumentoAsociado();
        this.cargarCubiculos();
    }
};
</script>
