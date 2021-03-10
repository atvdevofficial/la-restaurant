<template>
    <v-container fill-height fluid grid-list-xl>
        <v-row>
            <v-col md12 sm12 lg4 v-for="(chart, index) in charts" :key="index">
                <material-chart-card
                    :data="chart.data"
                    :options="chart.options"
                    :color="chart.design.color"
                    :type="chart.design.type"
                    :responsive-options="chart.responsiveOptions"
                >
                    <h4 class="title font-weight-light">{{chart.label.title}}</h4>
                    <p class="category d-inline-flex font-weight-light">
                        {{chart.label.subtitle}}
                    </p>

                    <template slot="actions">
                        <v-icon class="mr-2" small>
                            mdi-clock-outline
                        </v-icon>
                        <span class="caption grey--text font-weight-light"
                            >{{chart.label.time}}</span
                        >
                    </template>
                </material-chart-card>
            </v-col>
        </v-row>
        <v-row>
            <v-col sm6 xs12 md6 lg3 v-for="(stat, index) in stats" :key="index">
                <material-stats-card
                    :color="stat.color"
                    :icon="stat.icon"
                    :title="stat.title"
                    :value="stat.value"
                    :small-value="stat.smallvalue"
                    :sub-icon="stat.subicon"
                    :sub-icon-color="stat.subiconcolor"
                    :sub-text="stat.subtext"
                    :sub-text-color="stat.subtextcolor"
                />
            </v-col>
        </v-row>
        <v-row>
            <v-col md12 lg6>
                <material-card
                    color="orange"
                    title="Employee Stats"
                    text="New employees on 15th September, 2016"
                >
                    <v-data-table
                        :headers="headers"
                        :items="items"
                        hide-default-footer
                    >
                        <template
                            v-for="h in headers"
                            v-slot:[`header.${h.value}`]
                        >
                            <span
                                class="font-weight-light text-warning text--darken-3"
                                v-text="h.text"
                            />
                        </template>
                        <template slot="items" slot-scope="{ index, item }">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.name }}</td>
                            <td class="text-xs-right">{{ item.salary }}</td>
                            <td class="text-xs-right">{{ item.country }}</td>
                            <td class="text-xs-right">{{ item.city }}</td>
                        </template>
                    </v-data-table>
                </material-card>
            </v-col>
            <v-col md12 lg6>
                <material-card color="green">
                    <v-row slot="header">
                        <v-col style="align-self: center">
                            <span class="title font-weight-light mr-3">
                                Tasks:
                            </span>
                        </v-col>
                        <v-spacer></v-spacer>
                        <v-col class="text-right">
                            <v-btn
                                small
                                color="primary"
                                class="mr-5"
                            >
                                <v-icon small left>mdi-printer</v-icon> Print Codes
                            </v-btn>
                        </v-col>
                    </v-row>
                </material-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            charts:[
                {
                    data: {
                        labels: ["M", "T", "W", "T", "F", "S", "S"],
                        series: [[12, 17, 7, 17, 23, 18, 38]]
                    },
                    options: {
                        axisY: {
                            type: this.$chartist.FixedScaleAxis,
                            ticks: [0, 10, 20, 30, 40],
                            low: 0,
                            high: 50
                        },
                        lineSmooth: this.$chartist.Interpolation.cardinal({
                            tension: 0
                        }),
                        low: 0,
                        high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                        chartPadding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }
                    },
                    label: {
                        title: 'Daily Sales',
                        subtitle: "Increase in today's sales",
                        time: 'updated 4 minutes ago',
                    },
                    design:{
                        color: 'info',
                        type: 'Line',
                    }
                },
                {
                    data: {
                        labels: [
                            "12am",
                            "3pm",
                            "6pm",
                            "9pm",
                            "12pm",
                            "3am",
                            "6am",
                            "9am"
                        ],
                        series: [[230, 750, 450, 300, 280, 240, 200, 190]]
                    },
                    options: {
                        axisY: {
                            type: this.$chartist.FixedScaleAxis,
                            ticks: [0, 200, 400, 600, 800, 1000],
                            low: 0,
                            high: 1000
                        },
                        lineSmooth: this.$chartist.Interpolation.cardinal({
                            tension: 0
                        }),
                        low: 0,
                        high: 1000, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                        chartPadding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }
                    },
                    label: {
                        title: 'Email Subscription',
                        subtitle: "Last Campaign Performance",
                        time: 'updated 10 minutes ago',
                    },
                    design:{
                        color: 'red',
                        type: 'Bar',
                    }
                },
                {
                    data: {
                        labels: [
                            "Ja",
                            "Fe",
                            "Ma",
                            "Ap",
                            "Mai",
                            "Ju",
                            "Jul",
                            "Au",
                            "Se",
                            "Oc",
                            "No",
                            "De"
                        ],
                        series: [
                            [
                                542,
                                443,
                                320,
                                780,
                                553,
                                453,
                                326,
                                434,
                                568,
                                610,
                                756,
                                895
                            ]
                        ]
                    },
                    options: {
                        axisY: {
                            type: this.$chartist.FixedScaleAxis,
                            ticks: [0, 200, 400, 600, 800, 1000],
                            low: 0,
                            high: 1000
                        },
                        axisX: {
                            showGrid: false
                        },
                        low: 0,
                        high: 1000,
                        chartPadding: {
                            top: 0,
                            right: 5,
                            bottom: 0,
                            left: 0
                        }
                    },
                    responsiveOptions: [
                        [
                            "screen and (max-width: 640px)",
                            {
                                seriesBarDistance: 5,
                                axisX: {
                                    labelInterpolationFnc: function(value) {
                                        return value[0];
                                    }
                                }
                            }
                        ]
                    ],
                    label: {
                        title: 'Completed Tasks',
                        subtitle: "Last Last Campaign Performance",
                        time: 'campaign sent 26 minutes ago',
                    },
                    design:{
                        color: 'green',
                        type: 'Line',
                    }
                },
            ],
            stats:[
                {
                    color: "green",
                    icon: "mdi-store",
                    title: "Revenue",
                    value: "$34,245",
                    smallvalue:"",
                    subicon: "mdi-calendar",
                    subiconcolor:"",
                    subtext: "Last 24 Hours",
                    subtextcolor:"",
                },
                {
                    color:"orange",
                    icon:"mdi-content-copy",
                    title:"Used Space",
                    value:"49/50",
                    smallvalue:"GB",
                    subicon:"mdi-alert",
                    subiconcolor:"error",
                    subtext:"Get More Space...",
                    subtextcolor:"text-primary",
                },
                {
                    color:"red",
                    icon:"mdi-information-outline",
                    title:"Fixed Issues",
                    value:"75",
                    smallvalue:"",
                    subicon:"mdi-tag",
                    subiconcolor:"",
                    subtext:"Tracked from Github",
                    subtextcolor:"",
                },
                {
                    color:"info",
                    icon:"mdi-twitter",
                    title:"Followers",
                    value:"+245",
                    smallvalue:"",
                    subicon:"mdi-update",
                    subiconcolor:"",
                    subtext:"Just Updated",
                    subtextcolor:"",
                },

            ],
            headers: [
                {
                    sortable: false,
                    text: "ID",
                    value: "id"
                },
                {
                    sortable: false,
                    text: "Name",
                    value: "name"
                },
                {
                    sortable: false,
                    text: "Salary",
                    value: "salary",
                    align: "right"
                },
                {
                    sortable: false,
                    text: "Country",
                    value: "country",
                    align: "right"
                },
                {
                    sortable: false,
                    text: "City",
                    value: "city",
                    align: "right"
                }
            ],
            items: [
                {
                    name: "Dakota Rice",
                    country: "Niger",
                    city: "Oud-Tunrhout",
                    salary: "$35,738"
                },
                {
                    name: "Minerva Hooper",
                    country: "Curaçao",
                    city: "Sinaai-Waas",
                    salary: "$23,738"
                },
                {
                    name: "Sage Rodriguez",
                    country: "Netherlands",
                    city: "Overland Park",
                    salary: "$56,142"
                },
                {
                    name: "Philip Chanley",
                    country: "Korea, South",
                    city: "Gloucester",
                    salary: "$38,735"
                },
                {
                    name: "Doris Greene",
                    country: "Malawi",
                    city: "Feldkirchen in Kārnten",
                    salary: "$63,542"
                }
            ],
            tabs: 0,
            list: {
                0: false,
                1: false,
                2: false
            }
        };
    },
    methods: {
        complete(index) {
            this.list[index] = !this.list[index];
        }
    }
};
</script>
