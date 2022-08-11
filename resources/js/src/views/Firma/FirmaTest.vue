<template>
    <div>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <vx-card title="Bincard">
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <div class="vx-row">
                        <div class="vx-col w-full mt-5">
                            <h6>
                                Ingregar Codigo OTP Si es Firma Atendida, Sino
                                deje en blanco
                            </h6>
                            <vs-input class="inputx w-full  " v-model="otp" />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="GenerarJWT"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Firmar Documento</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="GenerarFirmaDocCreado"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Firmar con Mas Firmas</vs-button
                            >
                        </div>
                    </div>
                    <div class="vx-row"></div>
                </div>
            </vx-card>
            <div class="vx-row"></div>
        </div>
    </div>
</template>
<script>
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import moment from "moment";
import axios from "axios";
import vSelect from "vue-select";
import router from "@/router";
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
        PlusCircleIcon,
        flatPickr
    },
    data() {
        return {
            //Datos Locales - Variables de Entorno
            localVal: process.env.MIX_APP_URL,
            localDoc: process.env.MIX_APP_URL_DOCUMENTOS,
            //Datos Listado
            rows: [],
            otp: 0,
            cont: 1
        };
    },
    methods: {
        //Metodos Reusables
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
        },
        GenerarJWT() {
            try {
                let secreto = "4a191562d7b2476d8dcb13f265b4c7b1";
                const jwt = require("jsonwebtoken");
                let date = moment().add(30, "minutes");
                let fecha = date.format("YYYY-MM-DDTHH:mm:ss").toString();

                const user = {
                    entity: "Hospital San Luis de Buin - Paine",
                    run: "18499714",
                    expiration: fecha,
                    purpose: "Desatendido"
                };

                const token = jwt.sign(user, secreto, {
                    expiresIn: 60 * 30,
                    algorithm: "HS256"
                });

                let doc = this.cont.toString() + ".pdf";

                let tokenaa = "sandbox";

                let data = {
                    api_token_key: "d7f01566-48df-4a67-8388-4fc0b85d5c37",
                    token: token,
                    cont: doc.toString(),
                    link: this.localVal + "/Verificacion"
                };

                axios
                    .post(this.localVal + "/api/Firma/TestFirmaDigital", data, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        let tok = res.data;
                        const url =
                            this.localVal + "/DocumentosFirmados/" + tok;
                        window.open(url, "_blank");
                        //this.cont = parseInt(this.cont) + 1;
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GenerarFirmaDocCreado() {
            try {
                let secreto = "4a191562d7b2476d8dcb13f265b4c7b1";
                const jwt = require("jsonwebtoken");
                let date = moment().add(30, "minutes");
                let fecha = date.format("YYYY-MM-DDTHH:mm:ss").toString();

                const user = {
                    entity: "Hospital San Luis de Buin - Paine",
                    run: "18499714",
                    expiration: fecha,
                    purpose: "Desatendido"
                };

                const token = jwt.sign(user, secreto, {
                    expiresIn: 60 * 30,
                    algorithm: "HS256"
                });

                let doc = this.cont.toString() + ".pdf";

                let tokenaa = "sandbox";

                let data = {
                    api_token_key: "d7f01566-48df-4a67-8388-4fc0b85d5c37",
                    token: token,
                    cont: doc.toString(),
                    link: this.localVal + "/Verificacion"
                };

                axios
                    .post(this.localVal + "/api/Firma/PDFPrueba", data, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        let tok = res.data;
                        const url =
                            this.localVal + "/DocumentosFirmados/" + tok;
                        window.open(url, "_blank");
                        //this.cont = parseInt(this.cont) + 1;
                    });
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.RefreshToken();
        setTimeout(() => {}, 2000);
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1800px;
}
</style>
