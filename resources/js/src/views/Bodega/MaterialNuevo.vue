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
                                v-model="seleccionUbicacion"
                                placeholder="Ubicacion"
                                class="w-full select-large"
                                label="descripcion_ubicacion"
                                :options="listadoUbicacion"
                                @input="filtroSegunUbicacion"
                            >
                            </v-select>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.2 Seleccione Servicio</h6>
                            <br />
                            <v-select
                                v-model="seleccionServicio"
                                placeholder="Servicio"
                                class="w-full select-large"
                                label="descripcion_servicio"
                                :options="listadoServicio"
                                @input="filtroSegunServicio"
                            >
                            </v-select>
                        </div>
                    </div>
                    <div class="vx-row mb-4">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.3 Seleccione Material a Ingresar</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="valor"
                            ></vs-input>
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <h6>1.4 Seleccione Medida</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="cantidad"
                            />
                        </div>
                        <div class="vx-col w-1/6 mt-5">
                            <h6>Medida</h6>
                            <br />
                            <v-select
                                v-model="seleccionMedidas"
                                placeholder="Medidas"
                                class="w-full select-large"
                                label="descripcion_medidas"
                                :options="listadoMedidas"
                            />
                        </div>
                    </div>
                    <div class="vx-row mb-4">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.5 Ingrese Cantidad</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="cantidad"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.6 Ingrese Valor del Material</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="valor"
                            ></vs-input>
                        </div>
                    </div>
                </vx-card>
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
            seleccionUbicacion: {
                id: 0,
                descripcion_ubicacion: "Seleccione Ubicacion"
            },
            seleccionServicio: {
                id: 0,
                descripcion_servicio: "Seleccione Servicio"
            },
            seleccionMedidas: {
                id: 0,
                descripcion_medidas: "CC"
            },
            listadoUbicacion: [],
            listadoUbicacionData: [],
            listadoServicio: [],
            listadoServicioData: [],
            listadoMedidas: [],
            listadoMedidasData: [],
            cantidad: 0,
            valor: 0,
            medida: "cc",
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            run: sessionStorage.getItem("run"),
            localVal: process.env.MIX_APP_URL,
            componentKey: 0
        };
    },
    methods: {
        filtroSegunServicio() {
            if (this.seleccionServicio == null || this.seleccionServicio == 0) {
                this.listadoUbicacion = this.listadoUbicacionData;
                this.listadoServicio = this.listadoServicioData;
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
        cargarServicios() {
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
        },
        cargarMedidas() {
            axios
                .get(this.localVal + "/api/Bodega/GetMedidas", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoMedidas = res.data;
                    this.listadoMedidasData = res.data;
                });
        }
    },
    created() {
        this.cargarUbicaciones();
        this.cargarServicios();
        this.cargarMedidas();
    }
};
</script>
