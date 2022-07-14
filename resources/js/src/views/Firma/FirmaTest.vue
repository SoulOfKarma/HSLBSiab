<template>
    <div>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <vx-card title="Bincard">
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <div class="vx-row">
                        <div class="vx-col w-full mt-5">
                            <h6>.</h6>
                            <vs-input class="inputx w-full  " v-model="otp" />
                            <vs-button
                                @click="GenerarJWT"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Generar</vs-button
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
            otp: 0
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
                let secreto = "27a216342c744f89b7b82fa290519ba0";
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

                let data = {
                    api_token_key: "sandbox",
                    token: token,
                    otp: this.otp
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
                        console.log(tok);
                    });

                console.log(token);
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
