<template>
    <div class="card">
        <div class="card-header">
            Calendar
        </div>
            <div class="card-body">
            <notifications group="foo" />
                <div class="row">
                    <div class="col-md-4"> 
                        <div class="input-container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtEventName">Event Name</label>
                                        <input type="text" v-model="calendar.title" class="form-control" > 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="txtDateFrom">Date From</label>
                                        <input type="date" class="form-control" value="txtDateFrom" v-model="calendar.start" > 
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="txtDateTo">Date To</label>
                                        <input type="date" class="form-control" id="txtDateTo" v-model="calendar.end" > 
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="checkbox" id="chkMonday" value="Monday" v-model="daySelected">
                                    <label for="chkMonday">Mon </label>
                                    <input type="checkbox" id="chkTuesday" value="Tuesday" v-model="daySelected">
                                    <label for="chkTuesday">Tue </label>
                                    <input type="checkbox" id="chkWednesday" value="Wednesday" v-model="daySelected">
                                    <label for="chkWednesday">Wed </label>
                                    <input type="checkbox" id="chkThursday" value="Thursday" v-model="daySelected">
                                    <label for="chkThursday">Thu </label>
                                    <input type="checkbox" id="chkFriday" value="Friday" v-model="daySelected">
                                    <label for="chkFriday">Fri </label>
                                    <input type="checkbox" id="chkSaturday" value="Saturday" v-model="daySelected">
                                    <label for="chkSaturday">Sat </label>
                                    <input type="checkbox" id="chkSunday" value="Sunday" v-model="daySelected">
                                    <label for="chkSunday">Sun </label>
                                </div>
                                <div class="col-md-12">
                                     <button @click="addEvent" class="btn btn-primary">Save</button> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                      <div class="calendar-container"> 
                             <div id='calendar'></div>  
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
import Notifications from 'vue-notification';
import Vue from 'vue';

    export default {
        data() {
            return{
                calendar: {
                    title: null,
                    start: null,
                    end: null
                },
                daySelected: []                
            }
        },
        methods: {
            getEvents() {
                axios.get('http://127.0.0.1:8000/get-events').then((response) => {
                    var ctr = 0;
                    var data = [];

                    while(ctr < response.data.Data.length){
                        var arrObj = {
                            title: response.data.Data[ctr].event_name,
                            start: response.data.Data[ctr].start_date,
                            end: response.data.Data[ctr].end_date
                        }

                        data.push(arrObj);
                        ctr++;
                    }

                    this.displayEvents(data);
                });

            },
            displayEvents(data) {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    initialDate: '2021-01-15',
                    events: data
                });

                calendar.render();
            },
            addEvent() {
                var res = this.getDateRange(new Date(this.calendar.start), new Date(this.calendar.end), this.daySelected);

                axios.post('http://127.0.0.1:8000/add-events', { events: res }).then((response) => {
                        if(response.data.Status == 1){
                            this.getEvents();
                            
                            this.$notify({
                                group: 'foo',
                                title: 'Success',
                                text: response.data.Message,
                                type: 'success'
                            });
                        } else{
                            this.$notify({
                                group: 'foo',
                                title: 'Warning',
                                text: response.data.Message,
                                type: 'warn'
                            });
                        }
                });
            },
            getDateRange(start, end, daySelected) {
                var result = [];
                var days = {sun: 0, mon:1, tue:2, wed:3, thu:4, fri: 5,sat:6};
                var ctr = 0;

                while(ctr < daySelected.length) {
                    var day = days[daySelected[ctr].toLowerCase().substr(0,3)];
                    var current = new Date(start);

                    current.setDate(current.getDate() + (day - current.getDay() + 7) % 7);

                    while(current <= end) {
                        result.push( {
                            title: this.calendar.title, start: new Date(+current).toISOString().slice(0,10), end: new Date(+current).toISOString().slice(0,10)
                        });

                        current.setDate(current.getDate() + 7)
                    }

                    ctr++
                }
                    return result
            }
        },
        mounted() {
             this.getEvents();
        }
    }
     
</script>

<style>
    .input-container{
        padding: 10px;
    }

    .calendar-container{
        padding: 10px;
    }
</style>
