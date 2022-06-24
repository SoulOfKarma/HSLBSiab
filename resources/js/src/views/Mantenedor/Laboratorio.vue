<template>
    <div>
        <vx-card title="Laboratorio">
            <div>
                <vs-button color="primary" type="filled" @click="popLaboratorio"
                    >Agregar Laboratorio</vs-button
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
                                    content="Modificar Laboratorio"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarLaboratorio(
                                            props.row.id,
                                            props.row.LABORATORIO,
                                            props.row.RAZONSOCIAL
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
                classContent="Laboratorio"
                title="Agregar Laboratorio"
                :active.sync="popUpLaboratorio"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre Laboratorio</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="nomLaboratorio"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Razon Social</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="razonSocial"
                                />
                            </div>
                        </div>
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="popUpLaboratorio = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="AgregarLaboratorio"
                                    color="success"
                                    type="filled"
                                    class="w-full m-1"
                                    >Agregar Laboratorio</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="Laboratorio"
                title="Modificar Laboratorio"
                :active.sync="popUpLaboratorioMod"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre Laboratorio</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="nomLaboratorio"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Razon Social</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="razonSocial"
                                />
                            </div>
                        </div>
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="popUpLaboratorioMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="ModificarLaboratorio"
                                    color="warning"
                                    type="filled"
                                    class="w-full m-1"
                                    >Modificar Laboratorio</vs-button
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
            popUpLaboratorio: false,
            popUpLaboratorioMod: false,
            nomLaboratorio: "",
            razonSocial: "",
            idMod: 0,
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "Laboratorio",
                    field: "LABORATORIO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Razon Social",
                    field: "RAZONSOCIAL",
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
                this.nomLaboratorio = "";
                this.razonSocial = "";
                this.idMod = 0;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popLaboratorio() {
            try {
                this.popUpLaboratorio = true;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarLaboratorio(id, NomLab, RazSocLab) {
            try {
                this.popUpLaboratorioMod = true;
                this.idMod = id;
                this.nomLaboratorio = NomLab;
                this.razonSocial = RazSocLab;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD Laboratorio
        TraerLaboratorios() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetLaboratorio", {
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
                                    "No hay datos o no se cargaron los Laboratorios correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarLaboratorio() {
            try {
                if (this.nomLaboratorio == "" || this.nomLaboratorio == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un laboratorio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.razonSocial == "" || this.razonSocial == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una razon social",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        LABORATORIO: this.nomLaboratorio.toUpperCase(),
                        RAZONSOCIAL: this.razonSocial.toUpperCase()
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/PostLaboratorio",
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
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text: "Laboratorio Ingresado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpLaboratorio = false;
                                this.TraerLaboratorios();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible registrar al Laboratorio,intentelo nuevamente",
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
        ModificarLaboratorio() {
            try {
                let data = {
                    id: this.idMod,
                    LABORATORIO: this.nomLaboratorio.toUpperCase(),
                    RAZONSOCIAL: this.razonSocial.toUpperCase()
                };

                const dat = data;

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PutLaboratorio",
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
                                text: "Laboratorio Ingresado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpLaboratorioMod = false;
                            this.TraerLaboratorios();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar al Laboratorio,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        RefreshToken() {
            try {
                let data = {
                    token: sessionStorage.getItem("token")
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
                            window.sessionStorage.clear();
                            window.localStorage.clear();
                            router.push("/pages/login");
                        } else {
                            sessionStorage.setItem("token", tok);
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
            this.TraerLaboratorios();
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
