<template>
    <div style="line-height: 0.8; font-size: 12px;">
        <div class="vx-col md:w-1/1 w-full mb-base">
            <vx-card title="Reportes">
                <vs-prompt
                    title="Exportar a Excel"
                    class="export-options"
                    @cancle="clearFields"
                    @accept="exportToExcel"
                    accept-text="Export"
                    @close="clearFields"
                    :active.sync="activePrompt"
                >
                    <vs-input
                        v-model="fileName"
                        placeholder="Escriba el nombre del archivo..."
                        class="w-full"
                    />
                    <v-select
                        v-model="selectedFormat"
                        :options="formats"
                        class="my-4"
                    />
                    <div class="flex">
                        <span class="mr-4">Cell Auto Width:</span>
                        <vs-switch v-model="cellAutoWidth"
                            >Cell Auto Width</vs-switch
                        >
                    </div>
                </vs-prompt>
                <div class="vx-row mb-12">
                    <div class="vx-col w-full mt-5">
                        <vs-button @click="activePrompt = true"
                            >Exportar</vs-button
                        >
                    </div>
                </div>
                <div class="vx-col md:w-1/1 w-full mb-base mt-2">
                    <div class="vx-col w-full mt-5">
                        <h6>Seleccione Reporte</h6>
                        <br />
                        <v-select
                            taggable
                            v-model="seleccionReporte"
                            placeholder="Ej. Bincard"
                            class="w-full select-large"
                            label="descripcionReporte"
                            :options="listadoReportes"
                            @input="GetReporteEspecifico"
                        ></v-select>
                    </div>
                    <!-- Carga ConsumoXAño -->
                    <div class="vx-row" v-if="consumoanio">
                        <div class="vx-col w-1/5 mt-2">
                            <h6>Codigo Inicial</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codini"
                                :maxlength="7"
                            />
                        </div>
                        <div class="vx-col w-1/5 mt-2">
                            <h6>Codigo Final</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codter"
                                :maxlength="7"
                            />
                        </div>
                        <div class="vx-col w-1/5 mt-2">
                            <h6>Fecha Inicio</h6>
                            <flat-pickr
                                :config="configFromdateTimePicker"
                                v-model="fechaInicio"
                                placeholder="Fecha Inicio"
                                @on-change="onFromChange"
                                class="w-full "
                            />
                        </div>
                        <div class="vx-col w-1/5 mt-2">
                            <h6>Fecha Termino</h6>
                            <flat-pickr
                                :config="configTodateTimePicker"
                                v-model="fechaTermino"
                                placeholder="Fecha Termino"
                                @on-change="onToChange"
                                class="w-full "
                            />
                        </div>
                        <div class="vx-col w-1/5 mt-2">
                            <h6>.</h6>
                            <vs-button
                                @click="GetConsumoAnio"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Buscar</vs-button
                            >
                        </div>
                    </div>
                    <!-- Carga Saldo General - Valorizado -->
                    <div v-if="saldoGeneral">
                        <div class="vx-row w-full" v-if="saldoGeneral">
                            <div class="vx-col w-full mt-5">
                                <h6>Seleccione Saldo General</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionSaldoGTipo"
                                    placeholder="Ej. Bincard"
                                    class="w-full select-large"
                                    label="descripcion"
                                    :options="listaSaldoGTipo"
                                ></v-select>
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionSaldoGTipo.id == 1"
                        >
                            <div class="vx-col w-1/2 mt-2">
                                <h6>Ingrese Codigo o Descripcion a Buscar</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codinisal"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetSaldos"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Saldo Productos</vs-button
                                >
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionSaldoGTipo.id == 2"
                        >
                            <div class="vx-col w-1/2 mt-2">
                                <h6>Ingrese Codigo o Descripcion a Buscar</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codinisalv"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetSaldoValorizado"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Saldo Valorizado</vs-button
                                >
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionSaldoGTipo.id == 3"
                        >
                            <div class="vx-col w-full mt-2">
                                <h6>Busqueda Recepcion Por Rango</h6>
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Codigo Inicial</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codini"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Codigo Final</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codter"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Fecha Inicio</h6>
                                <flat-pickr
                                    :config="configFromdateTimePicker"
                                    v-model="fechaInicio"
                                    placeholder="Fecha Inicio"
                                    @on-change="onFromChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Fecha Termino</h6>
                                <flat-pickr
                                    :config="configTodateTimePicker"
                                    v-model="fechaTermino"
                                    placeholder="Fecha Termino"
                                    @on-change="onToChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetRecepcionesRango"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Buscar</vs-button
                                >
                            </div>
                        </div>
                    </div>
                    <!-- Carga ConsumoXMes -->
                    <div class="vx-row" v-if="consumomes">
                        <div class="vx-col w-1/4 mt-2">
                            <h6>Codigo Inicial</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codini"
                                :maxlength="7"
                            />
                        </div>
                        <div class="vx-col w-1/4 mt-2">
                            <h6>Codigo Final</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codter"
                                :maxlength="7"
                            />
                        </div>
                        <div class="vx-col w-1/4 mt-2">
                            <h6>Seleccione Mes</h6>
                            <v-select
                                v-model="seleccionMes"
                                placeholder="Ej. Junio"
                                class="w-full select-large"
                                label="descripcionMes"
                                :options="listadoMes"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/4 mt-2">
                            <h6>.</h6>
                            <vs-button
                                @click="GetConsumoMes"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Buscar</vs-button
                            >
                        </div>
                    </div>
                    <!-- Carga ConsumoXServicio -->
                    <div class="vx-row" v-if="consumomesservicio">
                        <div class="vx-col w-1/5 mt-2">
                            <h6>Codigo Inicial</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codini"
                                :maxlength="7"
                            />
                        </div>
                        <div class="vx-col w-1/5 mt-2">
                            <h6>Codigo Final</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codter"
                                :maxlength="7"
                            />
                        </div>
                        <div class="vx-col w-1/5 mt-2">
                            <h6>Seleccione Mes</h6>
                            <v-select
                                v-model="seleccionMes"
                                placeholder="Ej. Junio"
                                class="w-full select-large"
                                label="descripcionMes"
                                :options="listadoMes"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/5 mt-2">
                            <h6>Seleccione Servicio</h6>
                            <v-select
                                v-model="seleccionServicios"
                                placeholder="Ej. INFORMATICA"
                                class="w-full select-large"
                                label="descripcionServicio"
                                :options="listadoServicios"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/5 mt-2">
                            <h6>.</h6>
                            <vs-button
                                @click="GetConsumoMesServicio"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Buscar</vs-button
                            >
                        </div>
                    </div>
                    <!-- Carga Fecha Vencimiento/Cenabast-->
                    <div class="vx-row" v-if="fechavencimiento">
                        <div class="vx-col w-1/3 mt-2">
                            <h6>Codigo Inicial</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codini"
                                :maxlength="7"
                            />
                        </div>
                        <div class="vx-col w-1/3 mt-2">
                            <h6>Codigo Final</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codter"
                                :maxlength="7"
                            />
                        </div>
                        <div class="vx-col w-1/3 mt-2">
                            <h6>.</h6>
                            <vs-button
                                @click="GetFechaVencimiento"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Buscar</vs-button
                            >
                        </div>
                    </div>
                    <!-- Carga ZGen -->
                    <div class="vx-row" v-if="zgen">
                        <div class="vx-col w-1/2 mt-2">
                            <h6>Seleccione Mes</h6>
                            <v-select
                                v-model="seleccionMes"
                                placeholder="Ej. Junio"
                                class="w-full select-large"
                                label="descripcionMes"
                                :options="listadoMes"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/2 mt-2">
                            <h6>.</h6>
                            <vs-button
                                @click="GetZGen"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Buscar</vs-button
                            >
                        </div>
                    </div>
                    <br />
                    <!-- Carga ZGEN Priorizados -->
                    <div class="vx-row" v-if="zgenpriorizado">
                        <div class="vx-col w-1/2 mt-2">
                            <h6>Seleccione Mes</h6>
                            <v-select
                                v-model="seleccionMes"
                                placeholder="Ej. Junio"
                                class="w-full select-large"
                                label="descripcionMes"
                                :options="listadoMes"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/2 mt-2">
                            <h6>.</h6>
                            <vs-button
                                @click="GetZGenPriozados"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Buscar</vs-button
                            >
                        </div>
                    </div>
                    <!-- Carga Saldos PMP -->
                    <div v-if="saldopmp">
                        <div class="vx-row w-full" v-if="saldopmp">
                            <div class="vx-col w-full mt-5">
                                <h6>Seleccione Saldo PMP</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionSaldoTipo"
                                    placeholder="Ej. Bincard"
                                    class="w-full select-large"
                                    label="descripcion"
                                    :options="listaSaldoTipo"
                                ></v-select>
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionSaldoTipo.id == 1"
                        >
                            <div class="vx-col w-full mt-2">
                                <h6>Busqueda Por Bodega</h6>
                            </div>
                            <div class="vx-col w-1/4 mt-2">
                                <h6>Fecha Inicio</h6>
                                <flat-pickr
                                    :config="configFromdateTimePicker"
                                    v-model="fechaInicioF"
                                    placeholder="Fecha Inicio"
                                    @on-change="onFromChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/4 mt-2">
                                <h6>Fecha Termino</h6>
                                <flat-pickr
                                    :config="configTodateTimePicker"
                                    v-model="fechaTerminoF"
                                    placeholder="Fecha Termino"
                                    @on-change="onToChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/4 mt-2">
                                <h6>Bodega</h6>
                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/4 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetSaldoValorizadoPMPBodega"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Buscar</vs-button
                                >
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionSaldoTipo.id == 2"
                        >
                            <div class="vx-col w-full mt-2">
                                <h6>Busqueda Total Por Fecha</h6>
                            </div>
                            <div class="vx-col w-1/3 mt-2">
                                <h6>Fecha Inicio</h6>
                                <flat-pickr
                                    :config="configFromdateTimePicker"
                                    v-model="fechaInicioFE"
                                    placeholder="Fecha Inicio"
                                    @on-change="onFromChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/3 mt-2">
                                <h6>Fecha Termino</h6>
                                <flat-pickr
                                    :config="configTodateTimePicker"
                                    v-model="fechaTerminoFE"
                                    placeholder="Fecha Termino"
                                    @on-change="onToChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/3 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetSaldoValorizadoPMPXFechaFE"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Buscar</vs-button
                                >
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionSaldoTipo.id == 3"
                        >
                            <div class="vx-col w-full mt-2">
                                <h6>Busqueda Por Codigo/Fecha</h6>
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Codigo Inicial</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codiniC"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Codigo Final</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codterC"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Fecha Inicio</h6>
                                <flat-pickr
                                    :config="configFromdateTimePicker"
                                    v-model="fechaInicio"
                                    placeholder="Fecha Inicio"
                                    @on-change="onFromChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Fecha Termino</h6>
                                <flat-pickr
                                    :config="configTodateTimePicker"
                                    v-model="fechaTermino"
                                    placeholder="Fecha Termino"
                                    @on-change="onToChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetSaldoValorizadoPMPXCodigoFecha"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Buscar Por Codigo/Fecha</vs-button
                                >
                            </div>
                        </div>
                    </div>
                    <!-- Carga Elementos Bincard -->
                    <div v-if="bincardTipo">
                        <div class="vx-row w-full" v-if="bincardTipo">
                            <div class="vx-col w-full mt-5">
                                <h6>Seleccione Bincard</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionBincardTipo"
                                    placeholder="Ej. Bincard"
                                    class="w-full select-large"
                                    label="descripcion"
                                    :options="listaBincardTipo"
                                ></v-select>
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionBincardTipo.id == 1"
                        >
                            <div class="vx-col w-full mt-2">
                                <h6>Busqueda Por Bincard General</h6>
                            </div>
                            <div class="vx-col w-1/2 mt-2">
                                <h6>Ingrese Codigo, Descripcion a Buscar</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codbus"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetSaldoArticulos(1)"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Carga Bincard</vs-button
                                >
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionBincardTipo.id == 2"
                        >
                            <div class="vx-col w-full mt-2">
                                <h6>Busqueda Por Codigo/Fecha</h6>
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Codigo Inicial</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codini"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Codigo Final</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codter"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Fecha Inicio</h6>
                                <flat-pickr
                                    :config="configFromdateTimePicker"
                                    v-model="fechaInicio"
                                    placeholder="Fecha Inicio"
                                    @on-change="onFromChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Fecha Termino</h6>
                                <flat-pickr
                                    :config="configTodateTimePicker"
                                    v-model="fechaTermino"
                                    placeholder="Fecha Termino"
                                    @on-change="onToChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetSaldoArticulos(2)"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Buscar Por Codigo/Fecha</vs-button
                                >
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionBincardTipo.id == 3"
                        >
                            <div class="vx-col w-full mt-2">
                                <h6>Busqueda Por Codigo</h6>
                            </div>
                            <div class="vx-col w-1/3 mt-2">
                                <h6>Codigo Inicial</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codiniC"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/3 mt-2">
                                <h6>Codigo Final</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codterC"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/3 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetSaldoArticulos(4)"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Buscar Por Codigo</vs-button
                                >
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionBincardTipo.id == 4"
                        >
                            <div class="vx-col w-full mt-2">
                                <h6>Busqueda Por Codigo Covid</h6>
                            </div>
                            <div class="vx-col w-1/3 mt-2">
                                <h6>Codigo Inicial</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codiniCO"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/3 mt-2">
                                <h6>Codigo Final</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codterCO"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/3 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetSaldoArticulos(5)"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Buscar Por Codigo/Covid</vs-button
                                >
                            </div>
                        </div>
                    </div>
                    <!-- Carga Despacho Servicio -->
                    <div v-if="despachoxservicio">
                        <div class="vx-row w-full" v-if="despachoxservicio">
                            <div class="vx-col w-full mt-5">
                                <h6>Seleccione Despacho X Servicio</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionDespachoServicio"
                                    placeholder="Ej. Bincard"
                                    class="w-full select-large"
                                    label="descripcion"
                                    :options="listaDespachoServicio"
                                ></v-select>
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionDespachoServicio.id == 1"
                        >
                            <div class="vx-col w-full mt-2">
                                <h6>Busqueda Por todos los Servicios</h6>
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Codigo Inicial</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codini"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Codigo Final</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codter"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Fecha Inicio</h6>
                                <flat-pickr
                                    :config="configFromdateTimePicker"
                                    v-model="fechaInicio"
                                    placeholder="Fecha Inicio"
                                    @on-change="onFromChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Fecha Termino</h6>
                                <flat-pickr
                                    :config="configTodateTimePicker"
                                    v-model="fechaTermino"
                                    placeholder="Fecha Termino"
                                    @on-change="onToChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetDespachoxServicio"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Buscar</vs-button
                                >
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionDespachoServicio.id == 2"
                        >
                            <div class="vx-col w-full mt-2">
                                <h6>Busqueda Por Servicio</h6>
                            </div>
                            <div class="vx-col w-1/6 mt-2">
                                <h6>Codigo Inicial</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codiniC"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-2">
                                <h6>Codigo Final</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codterC"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-2">
                                <h6>Fecha Inicio</h6>
                                <flat-pickr
                                    :config="configFromdateTimePicker"
                                    v-model="fechaInicioF"
                                    placeholder="Fecha Inicio"
                                    @on-change="onFromChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-2">
                                <h6>Fecha Termino</h6>
                                <flat-pickr
                                    :config="configTodateTimePicker"
                                    v-model="fechaTerminoF"
                                    placeholder="Fecha Termino"
                                    @on-change="onToChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-2">
                                <h6>Seleccione Servicio</h6>
                                <v-select
                                    v-model="seleccionServicios"
                                    placeholder="Ej. INFORMATICA"
                                    class="w-full select-large"
                                    label="descripcionServicio"
                                    :options="listadoServicios"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/6 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetDespachoxServicioI"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Buscar</vs-button
                                >
                            </div>
                        </div>
                    </div>
                    <!-- Carga Consolidado Despacho -->
                    <div v-if="consolidadoDespacho">
                        <div class="vx-row w-full" v-if="consolidadoDespacho">
                            <div class="vx-col w-full mt-5">
                                <h6>Seleccione Consolidado Despacho</h6>
                                <v-select
                                    taggable
                                    v-model="seleccionConsolidadoDespacho"
                                    placeholder="Ej. Bincard"
                                    class="w-full select-large"
                                    label="descripcion"
                                    :options="listaConsolidadoDespacho"
                                ></v-select>
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionConsolidadoDespacho.id == 1"
                        >
                            <div class="vx-col w-full mt-2">
                                <h6>Busqueda Consolidado Despacho</h6>
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Codigo Inicial</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codini"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Codigo Final</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codter"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Fecha Inicio</h6>
                                <flat-pickr
                                    :config="configFromdateTimePicker"
                                    v-model="fechaInicio"
                                    placeholder="Fecha Inicio"
                                    @on-change="onFromChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Fecha Termino</h6>
                                <flat-pickr
                                    :config="configTodateTimePicker"
                                    v-model="fechaTermino"
                                    placeholder="Fecha Termino"
                                    @on-change="onToChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetConsolidadoDespacho"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Busqueda Consolidado</vs-button
                                >
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionConsolidadoDespacho.id == 2"
                        >
                            <div class="vx-col w-full mt-2">
                                <h6>Busqueda Covid 19</h6>
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Codigo Inicial</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codiniCO"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Codigo Final</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codterCO"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Fecha Inicio</h6>
                                <flat-pickr
                                    :config="configFromdateTimePicker"
                                    v-model="fechaInicioFE"
                                    placeholder="Fecha Inicio"
                                    @on-change="onFromChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>Fecha Termino</h6>
                                <flat-pickr
                                    :config="configTodateTimePicker"
                                    v-model="fechaTerminoFE"
                                    placeholder="Fecha Termino"
                                    @on-change="onToChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/5 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetConsolidadoDespachoCovid"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Busqueda Covid</vs-button
                                >
                            </div>
                        </div>
                        <div
                            class="vx-row w-full"
                            v-if="seleccionConsolidadoDespacho.id == 3"
                        >
                            <div class="vx-col w-full mt-2">
                                <h6>Busqueda Consolidado/Servicio</h6>
                            </div>
                            <div class="vx-col w-1/6 mt-2">
                                <h6>Codigo Inicial</h6>
                                <vs-input
                                    class="inputx w-full"
                                    v-model="codiniC"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-2">
                                <h6>Codigo Final</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codterC"
                                    :maxlength="7"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-2">
                                <h6>Fecha Inicio</h6>
                                <flat-pickr
                                    :config="configFromdateTimePicker"
                                    v-model="fechaInicioF"
                                    placeholder="Fecha Inicio"
                                    @on-change="onFromChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-2">
                                <h6>Fecha Termino</h6>
                                <flat-pickr
                                    :config="configTodateTimePicker"
                                    v-model="fechaTerminoF"
                                    placeholder="Fecha Termino"
                                    @on-change="onToChange"
                                    class="w-full "
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-2">
                                <h6>Seleccione Servicio</h6>
                                <v-select
                                    v-model="seleccionServicios"
                                    placeholder="Ej. INFORMATICA"
                                    class="w-full select-large"
                                    label="descripcionServicio"
                                    :options="listadoServicios"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/6 mt-2">
                                <h6>.</h6>
                                <vs-button
                                    @click="GetConsolidadoDespachoS"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Busqueda Consolidado/Servicio</vs-button
                                >
                            </div>
                        </div>
                    </div>
                    <br />
                    <vx-card title="">
                        <div class="vx-row">
                            <vue-good-table
                                v-if="listaActive"
                                class="w-full"
                                :columns="column"
                                :rows="listadoGeneral"
                                styleClass="vgt-table condensed bordered"
                            >
                                <template slot="table-row" slot-scope="props">
                                    <!-- Column: Name -->
                                    <span
                                        v-if="props.column.field === 'fullName'"
                                        class="text-nowrap"
                                    >
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'action'
                                        "
                                    >
                                        <plus-circle-icon
                                            content="Ver Bincard"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                GetBincard(1, props.row.CODART)
                                            "
                                        ></plus-circle-icon>
                                        <plus-circle-icon
                                            content="Ver Bincard PMP"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                GetBincardPmp(props.row.CODART)
                                            "
                                        ></plus-circle-icon>
                                        <plus-circle-icon
                                            content="Bincard Fecha Vencimiento y Lote"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                GetBincard(3, props.row.CODART)
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
                        </div>
                    </vx-card>
                </div>
            </vx-card>
        </div>
        <vs-popup
            classContent="Bincard"
            title="Bincard"
            :active.sync="popUpBincard"
        >
            <div
                class="vx-col md:w-1/1 w-full mb-base"
                style="line-height: 0.8; font-size: 12px;"
            >
                <vx-card title="">
                    <vue-good-table
                        :columns="columnBincard"
                        :rows="listaBincard"
                        :pagination-options="PageOptions"
                        styleClass="vgt-table condensed bordered"
                    >
                        <template slot="table-row" slot-scope="props">
                            <!-- Column: Name -->
                            <span
                                v-if="props.column.field === 'fullName'"
                                class="text-nowrap"
                            >
                            </span>
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </vx-card>
            </div>
        </vs-popup>
        <vs-popup
            classContent="BincardPMP"
            title="BincardPMP"
            :active.sync="popUpBincardPMP"
        >
            <div
                class="vx-col md:w-1/1 w-full mb-base"
                style="line-height: 0.8; font-size: 12px;"
            >
                <vx-card title="">
                    <vue-good-table
                        :columns="columnBincard"
                        :rows="listaBincard"
                        :pagination-options="PageOptions"
                        styleClass="vgt-table condensed bordered"
                    >
                        <template slot="table-row" slot-scope="props">
                            <!-- Column: Name -->
                            <span
                                v-if="props.column.field === 'fullName'"
                                class="text-nowrap"
                            >
                            </span>
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </vx-card>
            </div>
        </vs-popup>
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
import store from "./store.js";
import storePage from "../ScriptMenus/store.js";
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
            PageOptions: storePage.state.PageOptions,
            listaActive: false,
            bincardTipo: false,
            consumoanio: false,
            consumomes: false,
            consumomesservicio: false,
            despachoxservicio: false,
            fechavencimiento: false,
            zgen: false,
            zgenpriorizado: false,
            consolidadoDespacho: false,
            popUpBincard: false,
            popUpBincardPMP: false,
            fechaInicio: null,
            fechaTermino: null,
            fechaInicioF: null,
            fechaTerminoF: null,
            fechaInicioE: null,
            fechaTerminoE: null,
            fechaInicioFE: null,
            fechaTerminoFE: null,
            saldopmp: false,
            saldoGeneral: false,
            codbus: "",
            codini: "",
            codter: "",
            codiniC: "",
            codterC: "",
            codiniCO: "",
            codterCO: "",
            codinisal: "",
            codinisalv: "",
            idActBin: 1,
            idMod: 0,
            seleccionBodega: {
                id: 0,
                descripcionBodega: ""
            },
            seleccionReporte: {
                id: 0,
                descripcionReporte: "Ej. Bincard"
            },
            seleccionMes: {
                id: 0,
                descripcionMes: "Seleccione Mes"
            },
            seleccionServicios: {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
            },
            seleccionBincardTipo: {
                id: 0,
                descripcion: "Seleccione Tipo Bincard"
            },
            seleccionSaldoTipo: {
                id: 0,
                descripcion: "Seleccion Saldo"
            },
            seleccionSaldoGTipo: {
                id: 0,
                descripcion: "Seleccion Saldo General"
            },
            seleccionDespachoServicio: {
                id: 0,
                descripcion: "Seleccion Despacho Servicio"
            },
            seleccionConsolidadoDespacho: {
                id: 0,
                descripcion: "Seleccion Despacho Servicio"
            },
            //Datos para exportar
            fileName: "",
            formats: ["xlsx", "csv", "txt"],
            cellAutoWidth: true,
            selectedFormat: "xlsx",
            headerTitle: [],
            headerVal: [],
            activePrompt: false,
            //Datos Fechas
            configFromdateTimePicker: store.state.configFromdateTimePicker,
            configTodateTimePicker: store.state.configTodateTimePicker,
            configdateTimePicker: store.state.configdateTimePicker,
            configdateToTimePicker: store.state.configdateToTimePicker,
            //Configuracion Columnas
            column: [],
            columnBincard: [],
            //Datos Listado
            rows: [],
            listadoGeneral: [],
            listaBincard: [],
            listadoServicios: [],
            listaBodega: [],
            listadoReportes: store.state.listadoReportes,
            listadoMes: store.state.listadoMes,
            listaBincardTipo: store.state.listaBincardTipo,
            listaSaldoTipo: store.state.listaSaldoTipo,
            listaSaldoGTipo: store.state.listaSaldoGTipo,
            listaDespachoServicio: store.state.listaDespachoServicio,
            listaConsolidadoDespacho: store.state.listaConsolidadoDespacho
        };
    },
    methods: {
        //Metodos Reusables
        onFromChange(selectedDates, dateStr, instance) {
            this.$set(this.configTodateTimePicker, "minDate", dateStr);
        },
        onToChange(selectedDates, dateStr, instance) {
            this.$set(this.configFromdateTimePicker, "maxDate", dateStr);
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 1000);
        },
        limpiar() {
            this.fechaInicio = null;
            this.fechaTermino = null;
            this.fechaInicioF = null;
            this.fechaTerminoF = null;
            this.fechaInicioE = null;
            this.fechaTerminoE = null;
            this.fechaInicioFE = null;
            this.fechaTerminoFE = null;
            this.codini = "";
            this.codter = "";
            this.codiniC = "";
            this.codterC = "";
            this.codiniCO = "";
            this.codterCO = "";
            setTimeout(() => {
                this.cargarHoras();
                this.configFromdateTimePicker =
                    store.state.configFromdateTimePicker;
                this.configTodateTimePicker =
                    store.state.configTodateTimePicker;
                this.configdateTimePicker = store.state.configdateTimePicker;
                this.configdateToTimePicker =
                    store.state.configdateToTimePicker;
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
        volver() {
            try {
                this.$router.push({
                    name: "home"
                });
            } catch (error) {
                console.log(error);
            }
        },
        mensajeError() {
            this.$vs.notify({
                time: 5000,
                title: "Error",
                text: "No hay datos o no se cargaron los datos correctamente",
                color: "danger",
                position: "top-right"
            });
        },
        ListadoVistas() {
            this.consolidadoDespacho = false;
            this.despachoxservicio = false;
            this.bincardTipo = false;
            this.saldopmp = false;
            this.listaActive = true;
            this.consumoanio = false;
            this.consumomes = false;
            this.consumomesservicio = false;
            this.fechavencimiento = false;
            this.zgen = false;
            this.zgenpriorizado = false;
            this.saldoGeneral = false;
        },
        GetReporteEspecifico() {
            try {
                this.listaActive = true;
                this.consumoanio = false;
                this.consumomes = false;
                this.listadoGeneral = [];
                this.limpiar();
                this.columnBincard = [];
                this.columnBincard = store.state.columnBincardGeneral;
                this.cargarHoras();
                if (this.seleccionReporte.id == 1) {
                    this.ListadoVistas();
                    this.saldoGeneral = true;
                    //this.GetSaldos();
                } else if (this.seleccionReporte.id == 3) {
                    this.column = store.state.columnBincardInicial;
                    this.ListadoVistas();
                    this.bincardTipo = true;
                    //this.GetSaldoArticulos(1);
                } else if (this.seleccionReporte.id == 4) {
                    this.ListadoVistas();
                    this.consumoanio = true;
                } else if (this.seleccionReporte.id == 5) {
                    this.ListadoVistas();
                    this.consumomes = true;
                } else if (this.seleccionReporte.id == 6) {
                    this.ListadoVistas();
                    this.consumomesservicio = true;
                } else if (this.seleccionReporte.id == 7) {
                    this.ListadoVistas();
                    this.fechavencimiento = true;
                } else if (this.seleccionReporte.id == 8) {
                    this.ListadoVistas();
                    this.zgen = true;
                } else if (this.seleccionReporte.id == 9) {
                    this.ListadoVistas();
                    this.zgenpriorizado = true;
                } else if (this.seleccionReporte.id == 10) {
                    this.ListadoVistas();
                    this.saldopmp = true;
                    this.column = store.state.columnSaldoPmp;
                    //this.GetSaldoValorizadoPMP();
                } else if (this.seleccionReporte.id == 11) {
                    this.ListadoVistas();
                    this.despachoxservicio = true;
                    this.column = store.state.columnDespachoXServicio;
                } else if (this.seleccionReporte.id == 12) {
                    this.consolidadoDespacho = true;
                    this.despachoxservicio = false;
                    this.bincardTipo = false;
                    this.saldopmp = false;
                    this.listaActive = true;
                    this.consumoanio = false;
                    this.consumomes = false;
                    this.consumomesservicio = false;
                    this.fechavencimiento = false;
                    this.zgen = false;
                    this.zgenpriorizado = false;
                    this.saldoGeneral = false;
                    this.column = store.state.columnConsolidadoDespacho;
                }
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
        TraerBodega() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetBodega", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
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
        TraerServicio() {
            try {
                axios
                    .get(
                        this.localVal + "/api/Mantenedor/GetServiciosActivos",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let c = res.data;
                        let valor = 0;

                        let nombre = "";
                        let d = [];
                        c.forEach((val, index) => {
                            if (valor == 0) {
                                d.push(val);
                                valor = 1;
                                nombre = val.descripcionServicio;
                            } else if (nombre != val.descripcionServicio) {
                                d.push(val);
                                nombre = "";
                                nombre = val.descripcionServicio;
                            }
                        });

                        this.listadoServicios = d;
                        if (this.listadoServicios.length < 0) {
                            this.mensajeError();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetSaldoArticulos(idAction) {
            this.idActBin = idAction;
            try {
                if (this.idActBin == 1) {
                    let data = {
                        CODBUS: this.codbus
                    };
                    axios
                        .post(
                            this.localVal +
                                "/api/Reportes/GetArticulosSaldoEstado",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            this.listadoGeneral = res.data;
                            this.columnBincard = [];
                            this.limpiar();
                            this.columnBincard =
                                store.state.columnBincardGeneral;
                            this.headerTitle =
                                store.state.headerTitleBincardGeneral;
                            this.headerVal =
                                store.state.headerValBincardGeneral;
                            if (this.listadoGeneral.length < 0) {
                                this.mensajeError();
                            }
                        });
                } else if (this.idActBin == 2) {
                    let data = {
                        FECINI: moment(this.fechaInicio, "DD-MM-YYYY").format(
                            "YYYY-MM-DD"
                        ),
                        FECTER: moment(this.fechaTermino, "DD-MM-YYYY").format(
                            "YYYY-MM-DD"
                        ),
                        CODINI: this.codini,
                        CODTER: this.codter
                    };
                    axios
                        .post(
                            this.localVal +
                                "/api/Reportes/GetArticulosSaldoEstadoCF",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            this.listadoGeneral = res.data;
                            this.limpiar();
                            this.columnBincard = [];
                            this.columnBincard =
                                store.state.columnBincardGetArticulosSaldoEstadoCF;
                            this.headerTitle =
                                store.state.headerTitleGetArticulosSaldoEstadoCF;
                            this.headerVal =
                                store.state.headerValGetArticulosSaldoEstadoCF;
                            if (this.listadoGeneral.length < 0) {
                                this.mensajeError();
                            }
                        });
                } else if (this.idActBin == 3) {
                    axios
                        .get(
                            this.localVal +
                                "/api/Reportes/GetArticulosSaldoEstado",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            this.listadoGeneral = res.data;
                            this.limpiar();
                            this.columnBincard = [];
                            this.columnBincard =
                                store.state.columnBincardGetArticulosSaldoEstado;
                            this.headerTitle =
                                store.state.headerTitleGetArticulosSaldoEstado;
                            this.headerVal =
                                store.state.headerValGetArticulosSaldoEstado;
                            if (this.listadoGeneral.length < 0) {
                                this.mensajeError();
                            }
                        });
                } else if (this.idActBin == 4) {
                    let data = {
                        CODINI: this.codiniC,
                        CODTER: this.codterC
                    };
                    axios
                        .post(
                            this.localVal +
                                "/api/Reportes/GetArticulosSaldoEstadoC",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            this.listadoGeneral = res.data;
                            this.limpiar();
                            this.columnBincard = [];
                            this.columnBincard =
                                store.state.columnBincardGeneral;
                            this.headerTitle =
                                store.state.headerTitleBincardGeneral;
                            this.headerVal =
                                store.state.headerValBincardGeneral;
                            if (this.listadoGeneral.length < 0) {
                                this.mensajeError();
                            }
                        });
                } else if (this.idActBin == 5) {
                    let data = {
                        CODINI: this.codiniCO,
                        CODTER: this.codterCO
                    };
                    axios
                        .post(
                            this.localVal +
                                "/api/Reportes/GetArticulosSaldoEstadoCovid",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            this.listadoGeneral = res.data;
                            this.limpiar();
                            this.columnBincard = [];
                            this.columnBincard =
                                store.state.columnBincardGeneral;
                            this.headerTitle =
                                store.state.headerTitleBincardGeneral;
                            this.headerVal =
                                store.state.headerValBincardGeneral;
                            if (this.listadoGeneral.length < 0) {
                                this.mensajeError();
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        GetConsumoAnio() {
            try {
                let data = {
                    FECINI: moment(this.fechaInicio, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECTER: moment(this.fechaTermino, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    CODINI: this.codini,
                    CODTER: this.codter
                };
                axios
                    .post(
                        this.localVal + "/api/Reportes/GetConsumoAnio",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        this.limpiar();
                        if (this.listadoGeneral.length < 0) {
                            this.mensajeError();
                        } else {
                            this.column = store.state.columnConsumoAnio;
                            this.headerTitle =
                                store.state.headerTitleConsumoAnio;
                            this.headerVal = store.state.headerValConsumoAnio;
                            this.listaActive = true;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetConsumoMes() {
            try {
                let mes = "";
                if (this.seleccionMes.id > 0 && this.seleccionMes.id < 10) {
                    mes = "0" + this.seleccionMes.id;
                } else {
                    mes = this.seleccionMes.id;
                }
                let data = {
                    CODINI: this.codini,
                    CODTER: this.codter,
                    MES: mes
                };
                axios
                    .post(this.localVal + "/api/Reportes/GetConsumoMes", data, {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoGeneral = res.data;
                        this.limpiar();
                        if (this.listadoGeneral.length < 0) {
                            this.mensajeError();
                        } else {
                            this.column = store.state.columnConsumoMes;
                            this.headerTitle =
                                store.state.headerTitleConsumoMes;
                            this.headerVal = store.state.headerValConsumoMes;
                            this.listaActive = true;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetConsumoMesServicio() {
            try {
                let mes = "";
                if (this.seleccionMes.id > 0 && this.seleccionMes.id < 10) {
                    mes = "0" + this.seleccionMes.id;
                } else {
                    mes = this.seleccionMes.id;
                }
                let data = {
                    CODINI: this.codini,
                    CODTER: this.codter,
                    MES: mes,
                    NOMSER: this.seleccionServicios.descripcionServicio
                };
                if (
                    this.seleccionMes.id == 0 &&
                    this.seleccionServicios.id == 0
                ) {
                    this.mensajeError();
                }
                axios
                    .post(
                        this.localVal + "/api/Reportes/GetConsumoMesServicio",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        this.limpiar();
                        if (this.listadoGeneral.length < 0) {
                            this.mensajeError();
                        } else {
                            this.column = store.state.columnConsumoMesXServicio;
                            this.headerTitle =
                                store.state.headerTitleConsumoMesXServicio;
                            this.headerVal =
                                store.state.headerValConsumoMesXServicio;
                            this.listaActive = true;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetZGen() {
            try {
                let mes = "";
                if (this.seleccionMes.id > 0 && this.seleccionMes.id < 10) {
                    mes = "0" + this.seleccionMes.id;
                } else {
                    mes = this.seleccionMes.id;
                }
                let data = {
                    MES: mes
                };
                if (this.seleccionMes.id == 0) {
                    this.mensajeError();
                }
                axios
                    .post(this.localVal + "/api/Reportes/GetZGEN", data, {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoGeneral = res.data;
                        this.limpiar();
                        if (this.listadoGeneral.length < 0) {
                            this.mensajeError();
                        } else {
                            this.column = store.state.columnZgen;
                            this.headerTitle = store.state.headerTitleZGen;
                            this.headerVal = store.state.headerValZGen;
                            this.listaActive = true;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetZGenPriozados() {
            try {
                let mes = "";
                if (this.seleccionMes.id > 0 && this.seleccionMes.id < 10) {
                    mes = "0" + this.seleccionMes.id;
                } else {
                    mes = this.seleccionMes.id;
                }
                let data = {
                    MES: mes
                };
                if (this.seleccionMes.id == 0) {
                    this.mensajeError();
                }
                axios
                    .post(
                        this.localVal + "/api/Reportes/GetZGENPriorizados",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        this.limpiar();
                        if (this.listadoGeneral.length < 0) {
                            this.mensajeError();
                        } else {
                            this.column = store.state.columnZGenPriorizado;
                            this.headerTitle =
                                store.state.headerTitleZGenPriorizado;
                            this.headerVal =
                                store.state.headerValZGenPriorizado;
                            this.listaActive = true;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetBincard(ActBin, codart) {
            try {
                let data = {
                    CODART: codart
                };
                this.columnBincard = [];
                this.columnBincard = store.state.columnBincardGeneral;
                this.idActBin = ActBin;
                if (this.idActBin == 1) {
                    axios
                        .post(
                            this.localVal + "/api/Reportes/GetBincard",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let saldo = 0;
                            //this.limpiar();
                            let c = res.data;
                            if (c.length < 0) {
                                this.mensajeError();
                            } else {
                                let d = [];
                                c.forEach((value, index) => {
                                    let data = {
                                        TIPO: "",
                                        NOMBRE: "",
                                        FECHA: "",
                                        FOLDES: "",
                                        FOLREC: "",
                                        NUMORD: "",
                                        PROVEEDOR: "",
                                        CODART: "",
                                        CODBAR: "",
                                        PRECIO: "",
                                        CANTIDAD: "",
                                        SERVICIO: "",
                                        SALDO: "",
                                        NOMMOT: ""
                                    };
                                    if (value.TIPO == "Saldo Inventario") {
                                        saldo =
                                            parseInt(saldo) +
                                            parseInt(value.CANTIDAD);
                                    } else if (
                                        value.TIPO == "Recepcion" &&
                                        value.NOMMOT == "-"
                                    ) {
                                        saldo =
                                            parseInt(saldo) +
                                            parseInt(value.CANTIDAD);
                                    } else if (
                                        value.TIPO == "Recepcion" &&
                                        value.NOMMOT != "-"
                                    ) {
                                    } else if (
                                        value.TIPO == "Despacho" &&
                                        value.NOMMOT == "-"
                                    ) {
                                        saldo =
                                            parseInt(saldo) -
                                            parseInt(value.CANTIDAD);
                                    } else if (
                                        value.TIPO == "Despacho" &&
                                        value.NOMMOT != "-"
                                    ) {
                                    }

                                    data.TIPO = value.TIPO;
                                    data.NOMBRE = value.NOMBRE;
                                    data.FECHA = value.FECHA;
                                    data.FOLDES = value.FOLDES;
                                    data.FOLREC = value.FOLREC;
                                    data.NUMORD = value.NUMORD;
                                    data.PROVEEDOR = value.PROVEEDOR;
                                    data.CODART = value.CODART;
                                    data.CODBAR = value.CODBAR;
                                    data.PRECIO = value.PRECIO;
                                    data.CANTIDAD = value.CANTIDAD;
                                    data.SERVICIO = value.SERVICIO;
                                    data.SALDO = saldo;
                                    data.NOMMOT = value.NOMMOT;
                                    d.push(data);
                                });
                                this.listaBincard = d;
                                this.popUpBincard = true;
                            }
                        });
                } else if (this.idActBin == 2) {
                    axios
                        .post(
                            this.localVal + "/api/Reportes/GetBincard",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let saldo = 0;
                            this.limpiar();
                            let c = res.data;
                            if (c.length < 0) {
                                this.mensajeError();
                            } else {
                                let d = [];
                                c.forEach((value, index) => {
                                    let data = {
                                        TIPO: "",
                                        FECHA: "",
                                        NOMBRE: "",
                                        FOLREC: "",
                                        PROVEEDOR: "",
                                        FOLDES: "",
                                        SERVICIO: "",
                                        PRECIO: "",
                                        CANTIDAD: "",
                                        SALDO: ""
                                    };
                                    if (value.TIPO == "Saldo Inventario") {
                                        saldo =
                                            parseInt(saldo) +
                                            parseInt(value.CANTIDAD);
                                    } else if (
                                        value.TIPO == "Recepcion" &&
                                        value.NOMMOT == "-"
                                    ) {
                                        saldo =
                                            parseInt(saldo) +
                                            parseInt(value.CANTIDAD);
                                    } else if (
                                        value.TIPO == "Recepcion" &&
                                        value.NOMMOT != "-"
                                    ) {
                                    } else if (
                                        value.TIPO == "Despacho" &&
                                        value.NOMMOT == "-"
                                    ) {
                                        saldo =
                                            parseInt(saldo) -
                                            parseInt(value.CANTIDAD);
                                    } else if (
                                        value.TIPO == "Despacho" &&
                                        value.NOMMOT != "-"
                                    ) {
                                    }

                                    data.TIPO = value.TIPO;
                                    data.NOMBRE = value.NOMBRE;
                                    data.FECHA = value.FECHA;
                                    data.FOLDES = value.FOLDES;
                                    data.FOLREC = value.FOLREC;
                                    data.PROVEEDOR = value.PROVEEDOR;
                                    data.PRECIO = value.PRECIO;
                                    data.CANTIDAD = value.CANTIDAD;
                                    data.SERVICIO = value.SERVICIO;
                                    data.SALDO = saldo;
                                    d.push(data);
                                });
                                this.listaBincard = d;
                                this.popUpBincard = true;
                            }
                        });
                } else if (this.idActBin == 3) {
                    this.columnBincard = [];
                    this.columnBincard = store.state.columnBincardGeneralFL;
                    axios
                        .post(
                            this.localVal + "/api/Reportes/GetBincardFVen",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let saldo = 0;
                            this.limpiar();
                            let c = res.data;
                            if (c.length < 0) {
                                this.mensajeError();
                            } else {
                                let d = [];
                                c.forEach((value, index) => {
                                    let data = {
                                        TIPO: "",
                                        NOMBRE: "",
                                        FECHA: "",
                                        FOLDES: "",
                                        FOLREC: "",
                                        NUMORD: "",
                                        PROVEEDOR: "",
                                        CODART: "",
                                        CODBAR: "",
                                        PRECIO: "",
                                        CANTIDAD: "",
                                        SERVICIO: "",
                                        SALDO: "",
                                        FECVEN: "",
                                        LOTE: ""
                                    };
                                    if (value.TIPO == "Saldo Inventario") {
                                        saldo =
                                            parseInt(saldo) +
                                            parseInt(value.CANTIDAD);
                                    } else if (
                                        value.TIPO == "Recepcion" &&
                                        value.NOMMOT == "-"
                                    ) {
                                        saldo =
                                            parseInt(saldo) +
                                            parseInt(value.CANTIDAD);
                                    } else if (
                                        value.TIPO == "Despacho" &&
                                        value.NOMMOT == "-"
                                    ) {
                                        saldo =
                                            parseInt(saldo) -
                                            parseInt(value.CANTIDAD);
                                    }

                                    data.TIPO = value.TIPO;
                                    data.NOMBRE = value.NOMBRE;
                                    data.FECHA = value.FECHA;
                                    data.FOLDES = value.FOLDES;
                                    data.FOLREC = value.FOLREC;
                                    data.NUMORD = value.NUMORD;
                                    data.PROVEEDOR = value.PROVEEDOR;
                                    data.CODART = value.CODART;
                                    data.CODBAR = value.CODBAR;
                                    data.PRECIO = value.PRECIO;
                                    data.CANTIDAD = value.CANTIDAD;
                                    data.SERVICIO = value.SERVICIO;
                                    data.SALDO = saldo;
                                    data.FECVEN = value.FECVEN;
                                    data.LOTE = value.LOTE;
                                    d.push(data);
                                });
                                this.listaBincard = d;
                                this.popUpBincard = true;
                            }
                        });
                } else if (this.idActBin == 4) {
                    axios
                        .post(
                            this.localVal + "/api/Reportes/GetBincard",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let saldo = 0;
                            this.limpiar();
                            let c = res.data;
                            if (c.length < 0) {
                                this.mensajeError();
                            } else {
                                let d = [];
                                c.forEach((value, index) => {
                                    let data = {
                                        TIPO: "",
                                        NOMBRE: "",
                                        FECHA: "",
                                        FOLDES: "",
                                        FOLREC: "",
                                        NUMORD: "",
                                        PROVEEDOR: "",
                                        CODART: "",
                                        CODBAR: "",
                                        PRECIO: "",
                                        CANTIDAD: "",
                                        SERVICIO: "",
                                        SALDO: "",
                                        NOMMOT: ""
                                    };
                                    if (value.TIPO == "Saldo Inventario") {
                                        saldo =
                                            parseInt(saldo) +
                                            parseInt(value.CANTIDAD);
                                    } else if (
                                        value.TIPO == "Recepcion" &&
                                        value.NOMMOT == "-"
                                    ) {
                                        saldo =
                                            parseInt(saldo) +
                                            parseInt(value.CANTIDAD);
                                    } else if (
                                        value.TIPO == "Recepcion" &&
                                        value.NOMMOT != "-"
                                    ) {
                                    } else if (
                                        value.TIPO == "Despacho" &&
                                        value.NOMMOT == "-"
                                    ) {
                                        saldo =
                                            parseInt(saldo) -
                                            parseInt(value.CANTIDAD);
                                    } else if (
                                        value.TIPO == "Despacho" &&
                                        value.NOMMOT != "-"
                                    ) {
                                    }

                                    data.TIPO = value.TIPO;
                                    data.NOMBRE = value.NOMBRE;
                                    data.FECHA = value.FECHA;
                                    data.FOLDES = value.FOLDES;
                                    data.FOLREC = value.FOLREC;
                                    data.NUMORD = value.NUMORD;
                                    data.PROVEEDOR = value.PROVEEDOR;
                                    data.CODART = value.CODART;
                                    data.CODBAR = value.CODBAR;
                                    data.PRECIO = value.PRECIO;
                                    data.CANTIDAD = value.CANTIDAD;
                                    data.SERVICIO = value.SERVICIO;
                                    data.SALDO = saldo;
                                    data.NOMMOT = value.NOMMOT;
                                    d.push(data);
                                });
                                this.listaBincard = d;
                                this.popUpBincard = true;
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        GetBincardPmp(codart) {
            try {
                let data = {
                    CODART: codart
                };
                this.columnBincard = [];
                this.columnBincard = store.state.columnBincard;
                axios
                    .post(this.localVal + "/api/Reportes/GetBincard", data, {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        let saldo = 0;
                        //this.limpiar();
                        let c = res.data;
                        if (c.length < 0) {
                            this.mensajeError();
                        } else {
                            let d = [];
                            let saldoAnterior = 0;
                            c.forEach((value, index) => {
                                let data = {
                                    TIPO: "",
                                    NOMBRE: "",
                                    FECHA: "",
                                    FOLDES: "",
                                    FOLREC: "",
                                    NUMORD: "",
                                    PROVEEDOR: "",
                                    CODART: "",
                                    CODBAR: "",
                                    PRECIO: "",
                                    CANTIDAD: "",
                                    SERVICIO: "",
                                    SALDO: "",
                                    NOMMOT: ""
                                };
                                if (value.TIPO == "Saldo Inventario") {
                                    saldo =
                                        parseInt(saldo) +
                                        parseInt(value.CANTIDAD);
                                } else if (
                                    value.TIPO == "Recepcion" &&
                                    value.NOMMOT == "-"
                                ) {
                                    saldo =
                                        parseInt(saldo) +
                                        parseInt(value.CANTIDAD);
                                } else if (
                                    value.TIPO == "Recepcion" &&
                                    value.NOMMOT != "-"
                                ) {
                                } else if (
                                    value.TIPO == "Despacho" &&
                                    value.NOMMOT == "-"
                                ) {
                                    saldo =
                                        parseInt(saldo) -
                                        parseInt(value.CANTIDAD);
                                } else if (
                                    value.TIPO == "Despacho" &&
                                    value.NOMMOT != "-"
                                ) {
                                }

                                data.TIPO = value.TIPO;
                                data.NOMBRE = value.NOMBRE;
                                data.FECHA = value.FECHA;
                                data.FOLDES = value.FOLDES;
                                data.FOLREC = value.FOLREC;
                                data.NUMORD = value.NUMORD;
                                data.PROVEEDOR = value.PROVEEDOR;
                                data.CODART = value.CODART;
                                data.CODBAR = value.CODBAR;
                                data.PRECIO = value.PRECIO;
                                data.CANTIDAD = value.CANTIDAD;
                                data.SERVICIO = value.SERVICIO;
                                data.SALDO = saldo;
                                data.NOMMOT = value.NOMMOT;
                                data.TOTAL1 = value.CANTIDAD * value.PRECIO;
                                let totalcp = 0;
                                totalcp = value.CANTIDAD * value.PRECIO;
                                if (
                                    value.TIPO == "Despacho" &&
                                    value.NOMMOT == "-"
                                ) {
                                    saldoAnterior = saldoAnterior - totalcp;
                                    data.TOTAL2 = saldoAnterior;
                                    data.PMP = "-";
                                } else if (
                                    value.TIPO == "Despacho" &&
                                    value.NOMMOT != "-"
                                ) {
                                    saldoAnterior = saldoAnterior;
                                    data.TOTAL2 = saldoAnterior;
                                    data.PMP = "-";
                                } else {
                                    saldoAnterior = saldoAnterior + totalcp;
                                    data.TOTAL2 = saldoAnterior;
                                    data.PMP = saldoAnterior / saldo;
                                }

                                d.push(data);
                            });
                            this.listaBincard = d;
                            this.popUpBincardPMP = true;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetFechaVencimiento() {
            try {
                if (
                    this.codini == null &&
                    this.codini == "" &&
                    this.codter == null &&
                    this.codter == ""
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "Debe Ingresar el codigo inicial y de termino para realizar la busqueda",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        CODINI: this.codini,
                        CODTER: this.codter
                    };

                    axios
                        .post(
                            this.localVal + "/api/Reportes/GetFechaVencimiento",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            this.listadoGeneral = res.data;
                            this.limpiar();
                            if (this.listadoGeneral.length < 0) {
                                this.mensajeError();
                            } else {
                                this.column =
                                    store.state.columnFechaVencimiento;
                                this.listaActive = true;
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        GetSaldos() {
            try {
                let data = {
                    CODSAL: this.codinisal
                };
                axios
                    .post(
                        this.localVal + "/api/Reportes/GetSaldosReporte",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        this.limpiar();
                        this.column = store.state.columnSaldos;
                        this.headerTitle = [
                            "N° Interno",
                            "Z-Gen",
                            "Descripcion",
                            "Unidad Medida",
                            "Saldo"
                        ];
                        this.headerVal = [
                            "CODART",
                            "ZGEN",
                            "NOMBRE",
                            "UNIMED",
                            "saldoCorrecto"
                        ];
                        if (this.listadoGeneral.length < 0) {
                            this.mensajeError();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetRecepcionesRango() {
            try {
                let data = {
                    FECINI: moment(this.fechaInicio, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECTER: moment(this.fechaTermino, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    CODINI: this.codini,
                    CODTER: this.codter
                };
                axios
                    .post(
                        this.localVal + "/api/Reportes/GetSaldosRecepcion",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        this.column = store.state.columnSaldoV;
                        this.limpiar();
                        if (this.listadoGeneral.length < 0) {
                            this.mensajeError();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetDespachoxServicio() {
            try {
                let data = {
                    FECINI: moment(this.fechaInicio, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECTER: moment(this.fechaTermino, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    CODINI: this.codini,
                    CODTER: this.codter
                };
                axios
                    .post(
                        this.localVal + "/api/Reportes/GetDespachoxServicio",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        this.limpiar();
                        if (this.listadoGeneral.length < 0) {
                            this.mensajeError();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetDespachoxServicioI() {
            try {
                let data = {
                    FECINI: moment(this.fechaInicioF, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECTER: moment(this.fechaTerminoF, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    CODINI: this.codiniC,
                    CODTER: this.codterC,
                    NOMSER: this.seleccionServicios.descripcionServicio
                };
                axios
                    .post(
                        this.localVal + "/api/Reportes/GetDespachoxServicioI",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        this.limpiar();
                        if (this.listadoGeneral.length < 0) {
                            this.mensajeError();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetConsolidadoDespacho() {
            try {
                let data = {
                    FECINI: moment(this.fechaInicio, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECTER: moment(this.fechaTermino, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    CODINI: this.codini,
                    CODTER: this.codter
                };
                axios
                    .post(
                        this.localVal + "/api/Reportes/GetConsolidadoDespacho",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        this.limpiar();
                        if (this.listadoGeneral.length < 0) {
                            this.mensajeError();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetConsolidadoDespachoS() {
            try {
                let data = {
                    FECINI: moment(this.fechaInicioF, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECTER: moment(this.fechaTerminoF, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    CODINI: this.codiniC,
                    CODTER: this.codterC,
                    NOMSER: this.seleccionServicios.descripcionServicio
                };
                axios
                    .post(
                        this.localVal +
                            "/api/Reportes/GetConsolidadoDespachoServicio",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        this.limpiar();
                        if (this.listadoGeneral.length < 0) {
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
        GetConsolidadoDespachoCovid() {
            try {
                let data = {
                    FECINI: moment(this.fechaInicioFE, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECTER: moment(this.fechaTerminoFE, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    CODINI: this.codiniCO,
                    CODTER: this.codterCO
                };
                axios
                    .post(
                        this.localVal +
                            "/api/Reportes/GetConsolidadoDespachoServicioCovid",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        this.limpiar();
                        if (this.listadoGeneral.length < 0) {
                            this.mensajeError();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetSaldoValorizado() {
            try {
                let data = { CODSALV: this.codinisalv };
                axios
                    .post(
                        this.localVal +
                            "/api/Reportes/GetSaldosValorizadoReporte",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        this.column = store.state.columnSaldoV;
                        this.headerTitle = [
                            "N° Interno",
                            "Descripcion",
                            "Unidad Medida",
                            "Saldo",
                            "Ultimo Precio",
                            "Total"
                        ];
                        this.headerVal = [
                            "CODART",
                            "NOMBRE",
                            "UNIMED",
                            "saldoCorrecto",
                            "ULTPRE",
                            "TOTAL"
                        ];
                        this.limpiar();
                        if (this.listadoGeneral.length < 0) {
                            this.mensajeError();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetSaldoValorizadoPMP() {
            try {
                axios
                    .all([
                        axios.get(
                            this.localVal + "/api/Reportes/GetSaldoValorizadoP",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        ),
                        axios.get(
                            this.localVal +
                                "/api/Reportes/GetSaldosValorizadoPMP",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                    ])
                    .then(
                        axios.spread((res1, res2) => {
                            let resp1 = res1.data;
                            let resp2 = res2.data;
                            this.limpiar();
                            if (resp1.length > 0 && resp2.length > 0) {
                                this.listadoGeneral = [];
                                let d = [];
                                resp1.forEach((val, ind) => {
                                    resp2.forEach((value, index) => {
                                        if (val.CODART == value.CODART) {
                                            val.PMP = value.PMP;
                                            val.TOTAL = value.VALTOT;
                                            val.CODART2 = value.CODART;
                                            d.push(val);
                                        }
                                    });
                                });
                                this.listadoGeneral = d;
                                this.headerTitle = [
                                    "N° Interno",
                                    "Descripcion",
                                    "Unidad Medida",
                                    "Unidades",
                                    "Total",
                                    "PMP",
                                    "Ultimo Valor",
                                    "Menor Valor"
                                ];
                                this.headerVal = [
                                    "CODART",
                                    "NOMBRE",
                                    "UNIMED",
                                    "saldoCorrecto",
                                    "TOTAL",
                                    "PMP",
                                    "ULTPRE",
                                    "MINPRE"
                                ];
                            } else {
                                this.mensajeError();
                            }
                        })
                    );
            } catch (error) {
                console.log(error);
            }
        },
        GetSaldoValorizadoPMPBodega() {
            try {
                let data = {
                    FECINI: moment(this.fechaInicioF, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECTER: moment(this.fechaTerminoF, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    BODEGA: this.seleccionBodega.id
                };
                axios
                    .all([
                        axios.post(
                            this.localVal +
                                "/api/Reportes/GetSaldoValorizadoPBodega",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        ),
                        axios.post(
                            this.localVal +
                                "/api/Reportes/GetSaldosValorizadoPMPBodega",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                    ])
                    .then(
                        axios.spread((res1, res2) => {
                            this.limpiar();
                            let resp1 = res1.data;
                            let resp2 = res2.data;
                            if (resp1.length > 0 && resp2.length > 0) {
                                this.listadoGeneral = [];
                                let d = [];
                                resp1.forEach((val, ind) => {
                                    resp2.forEach((value, index) => {
                                        if (val.CODART == value.CODART) {
                                            val.PMP = value.PMP;
                                            val.TOTAL = value.VALTOT;
                                            val.CODART2 = value.CODART;
                                            d.push(val);
                                        }
                                    });
                                });
                                this.listadoGeneral = d;
                            } else {
                                this.mensajeError();
                            }
                        })
                    );
            } catch (error) {
                console.log(error);
            }
        },
        GetSaldoValorizadoPMPEconomato() {
            try {
                let data = {
                    FECINI: moment(this.fechaInicioE, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECTER: moment(this.fechaTerminoE, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    )
                };
                axios
                    .all([
                        axios.post(
                            this.localVal +
                                "/api/Reportes/GetSaldoValorizadoPEconomato",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        ),
                        axios.post(
                            this.localVal +
                                "/api/Reportes/GetSaldosValorizadoPMPEconomato",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                    ])
                    .then(
                        axios.spread((res1, res2) => {
                            this.limpiar();
                            let resp1 = res1.data;
                            let resp2 = res2.data;
                            if (resp1.length > 0 && resp2.length > 0) {
                                this.listadoGeneral = [];
                                let d = [];
                                resp1.forEach((val, ind) => {
                                    resp2.forEach((value, index) => {
                                        if (val.CODART == value.CODART) {
                                            val.PMP = value.PMP;
                                            val.TOTAL = value.VALTOT;
                                            val.CODART2 = value.CODART;
                                            d.push(val);
                                        }
                                    });
                                });
                                this.listadoGeneral = d;
                            } else {
                                this.mensajeError();
                            }
                        })
                    );
            } catch (error) {
                console.log(error);
            }
        },
        GetSaldoValorizadoPMPXFechaFE() {
            try {
                let data = {
                    FECINI: moment(this.fechaInicioFE, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECTER: moment(this.fechaTerminoFE, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    )
                };
                axios
                    .all([
                        axios.post(
                            this.localVal +
                                "/api/Reportes/GetSaldoValorizadoPCod",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        ),
                        axios.post(
                            this.localVal +
                                "/api/Reportes/GetSaldosValorizadoPMPCod",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                    ])
                    .then(
                        axios.spread((res1, res2) => {
                            this.limpiar();
                            let resp1 = res1.data;
                            let resp2 = res2.data;
                            if (resp1.length > 0 && resp2.length > 0) {
                                this.listadoGeneral = [];
                                let d = [];
                                resp1.forEach((val, ind) => {
                                    resp2.forEach((value, index) => {
                                        if (val.CODART == value.CODART) {
                                            val.PMP = value.PMP;
                                            val.TOTAL = value.VALTOT;
                                            val.CODART2 = value.CODART;
                                            d.push(val);
                                        }
                                    });
                                });
                                this.listadoGeneral = d;
                            } else {
                                this.mensajeError();
                            }
                        })
                    );
            } catch (error) {
                console.log(error);
            }
        },
        GetSaldoValorizadoPMPXCodigoFecha() {
            try {
                let data = {
                    codini: this.codiniC,
                    codter: this.codterC,
                    FECINI: moment(this.fechaInicio, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECTER: moment(this.fechaTermino, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    )
                };
                axios
                    .all([
                        axios.post(
                            this.localVal +
                                "/api/Reportes/GetSaldoValorizadoPCodFecha",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        ),
                        axios.post(
                            this.localVal +
                                "/api/Reportes/GetSaldosValorizadoPMPCodFecha",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                    ])
                    .then(
                        axios.spread((res1, res2) => {
                            this.limpiar();
                            let resp1 = res1.data;
                            let resp2 = res2.data;
                            if (resp1.length > 0 && resp2.length > 0) {
                                this.listadoGeneral = [];
                                let d = [];
                                resp1.forEach((val, ind) => {
                                    resp2.forEach((value, index) => {
                                        if (val.CODART == value.CODART) {
                                            val.PMP = value.PMP;
                                            val.TOTAL = value.VALTOT;
                                            val.CODART2 = value.CODART;
                                            d.push(val);
                                        }
                                    });
                                });
                                this.listadoGeneral = d;
                            } else {
                                this.mensajeError();
                            }
                        })
                    );
            } catch (error) {
                console.log(error);
            }
        },
        RefreshToken() {
            try {
                let data = {
                    token: localStorage.getItem("token")
                };
                axios
                    .post(this.localVal + "/api/auth/RefreshToken", data)
                    .then(res => {
                        let tok = res.data;
                        if (tok == "") {
                        } else if (tok == false) {
                            this.mensajeError();
                            window.localStorage.clear();
                            window.localStorage.clear();
                            router.push("/pages/login");
                        } else {
                            localStorage.setItem("token", tok);
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        cargarHoras() {
            try {
                let date = moment().endOf("day");
                this.fechaInicio = date.format("DD/MM/YYYY").toString();
                this.fechaTermino = date.format("DD/MM/YYYY").toString();
                this.fechaInicioF = date.format("DD/MM/YYYY").toString();
                this.fechaTerminoF = date.format("DD/MM/YYYY").toString();
                this.fechaInicioE = date.format("DD/MM/YYYY").toString();
                this.fechaTerminoE = date.format("DD/MM/YYYY").toString();
                this.fechaInicioFE = date.format("DD/MM/YYYY").toString();
                this.fechaTerminoFE = date.format("DD/MM/YYYY").toString();
            } catch (error) {
                console.log("No se cargo la ISO hora");
                console.log(error);
            }
        },
        exportToExcel() {
            import("@/vendor/Export2Excel").then(excel => {
                const list = this.listadoGeneral;
                const data = this.formatJson(this.headerVal, list);
                excel.export_json_to_excel({
                    header: this.headerTitle,
                    data,
                    filename: this.fileName,
                    autoWidth: this.cellAutoWidth,
                    bookType: this.selectedFormat
                });
                this.clearFields();
            });
        },
        formatJson(filterVal, jsonData) {
            return jsonData.map(v =>
                filterVal.map(j => {
                    // Add col name which needs to be translated
                    // if (j === 'timestamp') {
                    //   return parseTime(v[j])
                    // } else {
                    //   return v[j]
                    // }
                    return v[j];
                })
            );
        },
        clearFields() {
            this.filename = "";
            this.cellAutoWidth = true;
            this.selectedFormat = "xlsx";
        }
    },
    beforeMount() {
        this.RefreshToken();
        this.cargarHoras();
        setTimeout(() => {
            this.TraerBodega();
            this.TraerServicio();
        }, 2000);
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1900px;
}
</style>
