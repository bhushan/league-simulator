<template>
    <div>
        <div
                v-for="(week, weekIndex) in perWeekData"
                :key="weekIndex"
                class="grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3 sm:gap-6 gap-4 sm:m-2 md:my-10 md:mx-16 border-b py-4"
        >
            <table class="table-auto p-2">
                <thead>
                <tr>
                    <th colspan="7" class="border p-2">{{ $t('leagueTableHeading', {'weekNumber' : week.id})}}</th>
                </tr>
                </thead>
                <thead>
                <tr>
                    <th class="border p-2">{{ $t('teams') }}</th>
                    <th class="border p-2 text-right">{{ $t('points') }}</th>
                    <th class="border p-2 text-right">{{ $t('played') }}</th>
                    <th class="border p-2 text-right">{{ $t('won') }}</th>
                    <th class="border p-2 text-right">{{ $t('draw') }}</th>
                    <th class="border p-2 text-right">{{ $t('lost') }}</th>
                    <th class="border p-2 text-right">{{ $t('goalDifference') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(record, recordIndex) in week.records" :key="recordIndex">
                    <td class="border p-2" v-text="record.teamName"></td>
                    <td class="border p-2 text-right" v-text="record.points"></td>
                    <td class="border p-2 text-right" v-text="record.playedCount"></td>
                    <td class="border p-2 text-right" v-text="record.winCount"></td>
                    <td class="border p-2 text-right" v-text="record.drawCount"></td>
                    <td class="border p-2 text-right" v-text="record.lostCount"></td>
                    <td class="border p-2 text-right" v-text="record.goalDifference"></td>
                </tr>
                </tbody>
                <tfoot v-if="showIf(week.id)">
                <tr>
                    <td colspan="7">
                        <div class="py-2 flex justify-between">
                            <button
                                    @click.prevent="playAll"
                                    class="bg-blue-400 hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                            >{{ $t('playAll') }}
                            </button>
                            <button
                                    @click.prevent="nextWeek"
                                    class="bg-blue-400 hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                            >{{ $t('nextWeek') }}
                            </button>
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
            <table class="table-auto p-2">
                <thead>
                <tr>
                    <th colspan="2" class="border border p-2">{{ $t('matchResults') }}</th>
                    <th class="border-r border-t p-2 w-1/3 h-full text-right">
                        <button
                                v-if="!week.isEditing"
                                @click.prevent="week.isEditing = !week.isEditing"
                                class="bg-yellow-400 hover:bg-yellow-500 text-yellow-700 font-semibold hover:text-white py-1 px-2 border border-yellow-500 hover:border-transparent rounded"
                        >{{ $t('edit') }}
                        </button>
                        <button
                                v-else
                                @click.prevent="saveScores(weekIndex)"
                                class="bg-green-400 hover:bg-green-500 text-green-700 font-semibold hover:text-white py-1 px-2 border border-green-500 hover:border-transparent rounded"
                        >{{ $t('save') }}
                        </button>
                    </th>
                </tr>
                <tr>
                    <th class="border p-2" colspan="3">{{ $t('matchResultHeading', { 'weekNumber': week.id}) }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(match, matchIndex) in week.weeklyMatches" :key="matchIndex">
                    <td class="border p-2 w-1/3">{{ match.homeTeam }}</td>
                    <td
                            v-if="!week.isEditing"
                            class="border p-2 w-1/3 text-center"
                    >{{ match.homeTeamScore }} - {{ match.awayTeamScore }}
                    </td>
                    <td v-else class="border p-2 w-1/3">
                        <div class="flex justify-between">
                            <input
                                    type="number"
                                    min="0"
                                    class="w-1/3 bg-gray-600 text-center"
                                    v-model="match.homeTeamScore"
                            />
                            <span class="mx-2">-</span>
                            <input
                                    type="number"
                                    min="0"
                                    class="w-1/3 bg-gray-600 text-center"
                                    v-model="match.awayTeamScore"
                            />
                        </div>
                    </td>
                    <td class="border p-2 w-1/3">{{ match.awayTeam }}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <ul>
                            <li class="text-red-600" v-for="(error, errorIndex) in week.errors" :key="errorIndex"
                                v-text="error[0]"></li>
                        </ul>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table-auto p-2" v-if="week.id >= showPredictionFrom && week.id != weekCount">
                <thead>
                <tr>
                    <th colspan="2" rowspan="2" class="border p-2">
                        {{ $t('predictionHeading', {'weekNumber' : week.id}) }}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(prediction, predictionTeam) in week.predictions" :key="predictionTeam">
                    <td class="border p-2">{{ predictionTeam }}</td>
                    <td class="border p-2">{{ prediction }}%</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        props: ["weekCount", "showPredictionFrom"],

        data() {
            return {
                weekNumber: 1,
                perWeekData: [],
            };
        },
        created() {
            this.refresh();
        },
        methods: {
            getLeagueTablePath() {
                return "/api/league-table?week=" + this.weekNumber;
            },
            getSaveScorePath() {
                return "/api/matches";
            },
            showIf(weekId) {
                return weekId == this.weekNumber && weekId != this.weekCount;
            },
            refresh() {
                axios
                    .get(this.getLeagueTablePath())
                    .then(resp => {
                        this.updateDom(resp.data);
                    })
                    .catch(err => {
                        this.setErrors(this.weekNumber, err);
                    });
            },
            nextWeek() {
                this.weekNumber++;

                if (this.weekNumber > this.weekCount) {
                    this.weekNumber--;
                    return;
                }

                if (this.weekNumber <= this.weekCount) {
                    this.refresh();
                }
            },
            playAll() {
                this.weekNumber = this.weekCount;
                this.refresh();
            },
            saveScores(index) {
                this.perWeekData[index].isEditing = false;

                let form = {
                    weekId: this.perWeekData[index].id,
                    currentWeek: this.weekNumber,
                    weeklyMatches: this.perWeekData[index].weeklyMatches
                };

                axios
                    .patch(this.getSaveScorePath(), form)
                    .then(resp => {
                        this.updateDom(resp.data);
                    })
                    .catch(err => {
                        this.setErrors(index, err);
                    });
            },
            updateDom(data) {
                this.perWeekData = data;
            },
            setErrors(index, err) {
                this.perWeekData[index].errors = err.response.data.errors;
            }
        }
    };
</script>
