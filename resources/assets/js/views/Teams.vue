<template>
    <div>

        <b-alert show variant="success" v-show="success">{{message}}</b-alert>
        <b-alert show variant="danger" v-show="failed">{{error}}</b-alert>

        <b-button id="show-btn " variant="dark" @click="$bvModal.show('bv-modal-example')">+</b-button>
        <b-button id="show-btn " variant="dark" @click="$bvModal.show('assign-modal')">Assign</b-button>
        <b-button id="show-btn " variant="dark" @click="$bvModal.show('owner-modal')">Set Owner</b-button>



        <b-table
                striped hover
                :items="teams"
                :fields="fields"
        >
            <template slot="action" slot-scope="row">
<!--                <b-button size="sm" @click="info(row.item, row.index, $event.target)" class="mr-1" variant="info">-->
<!--                    Show Team-->
<!--                </b-button>-->
                <b-button size="sm" @click="row.toggleDetails" variant="info">
                   Team Members
                </b-button>
                <b-button size="sm" @click="open_modal(row.item, row.index, $event.target)" class="mr-2">
                    Edit
                </b-button>
                <b-button size="sm" @click="destroy(row.item, row.index, $event.target)" class="mr-2 btn-danger">
                    Delete
                </b-button>
            </template>
            <template slot="row-details" slot-scope="row">
                <b-card>
                    <ul>
                        <li v-for="(value, key) in row.item.users" :key="key" class="m-3">{{value.id}}: {{ value.name }} <small>( {{value.email}})</small>
                            <b-button size="sm" @click="un_sign(row.item.id, value.id,$event.target)" class="ml-5 mr-5 btn-danger">
                                X
                            </b-button>
                        </li>
                    </ul>
                </b-card>
            </template>
        </b-table>


        <b-modal id="bv-modal-example" hide-footer ref="my-modal">

            <b-form inline>
                <label class="sr-only" for="inline-form-input-name1">Name</label>
                <b-input
                        id="inline-form-input-name1"
                        class="mb-2 mr-sm-5 mb-sm-0"
                        placeholder="Team Title"
                        v-model="form.title"
                ></b-input>

                <b-button variant="primary" @click="create">Save</b-button>
            </b-form>

        </b-modal>
        <b-modal id="edit_modal" hide-footer ref="my-modal">
            <b-form inline>
                <label class="sr-only" for="inline-form-input-name">Name</label>
                <b-input
                        id="inline-form-input-name"
                        class="mb-2 mr-sm-5 mb-sm-0"
                        placeholder="Team Title"
                        v-model="team.title"

                ></b-input>


                <b-button variant="primary" @click="update">Update</b-button>
            </b-form>

        </b-modal>
        <b-modal id="assign-modal" hide-footer ref="my-modal">
            <b-form inline>
                <div class="form-group">
                    <label  for="user_select">User</label>
                    <b-form-select v-model="selected_user" :options="users" id="user_select" class="ml-3 mb-3 mr-3"></b-form-select>
                </div>
                <div class="form-group">

                    <label  for="team_select"> Team</label>
                    <b-form-select v-model="selected_team" :options="team_select" id="team_select" class="mb-3 ml-3"></b-form-select>
                </div>

                <b-button variant="primary" @click="assign" class="mb-3 ml-3 mr-3">Update</b-button>
            </b-form>

        </b-modal>
        <b-modal id="assign-modal" hide-footer ref="my-modal">
            <b-form inline>
                <div class="form-group">
                    <label  for="user_select">User</label>
                    <b-form-select v-model="selected_user" :options="users" id="user_select" class="ml-3 mb-3 mr-3"></b-form-select>
                </div>
                <div class="form-group">

                    <label  for="team_select"> Team</label>
                    <b-form-select v-model="selected_team" :options="team_select" id="team_select" class="mb-3 ml-3"></b-form-select>
                </div>

                <b-button variant="primary" @click="set_owner" class="mb-3 ml-3 mr-3">Update</b-button>
            </b-form>

        </b-modal>
    </div>


</template>

<script>
    // import {logout} from '../mixins/logout'
    import {store} from '../store/store'
    import 'bootstrap/dist/css/bootstrap.css'
    import 'bootstrap-vue/dist/bootstrap-vue.css'

    export default {
        // mixins: [logout],
        name: "Teams",
        data() {
            return {
                fields: [
                    {key: 'id'},
                    {key: 'title'},
                    {key: 'created_at'},
                    {key: 'action'}

                ],
                teams: [],
                users: [],
                form: {
                    title: '',
                },
                team: {
                    title: '',
                    id: ''
                },
                show: false,
                failed: false,
                success: false,
                error: '',
                message: '',
                filter: null,
                selected_user: null,
                selected_team: null,
                team_select: [],
            }
        },
        beforeCreate: function () {

            let vm = this
            this.$http.get('api/teams').then((response) => {
                response.body.map(function (value, key) {
                    vm.team_select.push({value: value.id, text: value.title})
                    vm.teams.push(value);
                });
            }, () => {

            })

            this.$http.get('api/users').then((response) => {
                response.body.map(function (value, key) {
                    vm.users.push({value: value.id, text: value.name})
                });
            })
        },

        methods: {
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.title = ''

                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            },
            hideModal() {
                this.$refs['my-modal'].hide()
            },
            create() {
                this.$http.post('api/teams', {title: this.form.title}).then((response) => {
                    this.teams.push(response.body)

                    this.hideModal()
                }, (error) => {
                    console.log(error)
                })
            },
            update() {
                this.$http.put('api/teams' + '/' + this.team.id, {
                    title: this.team.title,
                }).then((response) => {
                    this.teams.push(response.body)
                    this.hideModal()
                }, (error) => {
                    console.log(error)
                })

            },
            open_modal(item, index, button) {
                let team = JSON.parse(JSON.stringify(item, null, 2))
                this.team.title = team.title
                this.team.id = team.id
                this.$bvModal.show('edit_modal')
            },
            destroy(item, index, button) {

                let team = JSON.parse(JSON.stringify(item, null, 2))
                var confirm_delete = confirm('Are you sure to remove ?');

                if (confirm_delete) {
                    this.$http.delete('api/teams' + '/' + team.id, {
                        title: this.team.title,
                    }).then((response) => {
                        if (response.status == 200) {
                            this.success = true
                            this.message = response.body.success
                            let row = button.parentNode.parentNode;
                            row.parentNode.removeChild(row);
                        }
                    }, (error) => {
                        if (error.status == 401) {
                            this.error = error.body.failed
                            this.failed = true

                        }

                    })
                }
            },
            assign(){
                this.$http.post('api/assignTeam', {team_id: this.selected_team, user_id:this.selected_user}).then((response) => {
                    this.message = response.body.success

                    this.success = true
                    this.hideModal()
                }, (error) => {
                    this.error = error.body.failed
                    this.failed = true
                    this.hideModal()
                })
            },
            un_sign(team_id, user_id,button){


                this.$http.post('api/unAssignTeam', {team_id: team_id, user_id:user_id}).then((response) => {
                    this.message = response.body.success
                    this.success = true
                    let list = button.parentNode;
                    list.parentNode.removeChild(list);
                }, (error) => {
                    this.error = error.body.failed
                    this.failed = true
                })


            },
            set_owner(){
                this.$http.post('api/setOwner', {team_id: this.selected_team, user_id:this.selected_user}).then((response) => {
                    this.message = response.body.success

                    this.success = true
                    this.hideModal()
                }, (error) => {
                    this.error = error.body.failed
                    this.failed = true
                    this.hideModal()
                })
            },
        }

    }
</script>

<style scoped>


</style>