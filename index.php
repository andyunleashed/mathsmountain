<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mia's Maths Mountain</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://kit.fontawesome.com/ebd888569b.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="mountain.ico">
    <style>
        @media print {
            @page { margin: 0; }
        }
    </style>
</head>
<body class="px-4">
    <div x-data="mathsMountain()">
        <h1 class="hidden print:block font-bold text-3xl mt-4 py-4 pl-4">Maths Mountain! <i class="fa-sharp fa-light fa-mountain-sun"></i></h1>
        <div>
            <template x-if="challenge_type == 'operator'">
                <table class="table-fixed border-separate border-spacing-4 text-xl text-center" x-show="challenges">
                    <tbody>
                        <template x-for="challenge in challenges" :key="challenge.id">
                            <tr>
                                <td>
                                    <template x-if="challenge.first_number == placeholder">
                                        <div class="w-16">
                                            <input x-model.number="challenge.answer_given" @keyup.enter="checkAnswer(challenge)" type="text" class="w-full block p-2 border border-indigo-500 rounded text-center focus:outline focus:outline-4 focus:-outline-offset-2 focus:outline-pink-500" min="0" step="1">
                                        </div>
                                    </template>
                                    <template x-if="challenge.first_number != placeholder">
                                        <div class="w-16" x-text="challenge.first_number"></div>
                                    </template>
                                </td>
                                <td class="text-2xl" x-html="operator_symbol"></td>
                                <td>
                                    <template x-if="challenge.second_number == placeholder">
                                        <div class="w-16">
                                            <input x-model.number="challenge.answer_given" @keyup.enter="checkAnswer(challenge)" type="text" class="w-full block p-2 border border-indigo-500 rounded text-center focus:outline focus:outline-4 focus:-outline-offset-2 focus:outline-pink-500" min="0" step="1">
                                        </div>
                                    </template>
                                    <template x-if="challenge.second_number != placeholder">
                                        <div class="w-16" x-text="challenge.second_number"></div>
                                    </template>
                                </td>
                                <td class="text-2xl">&equals;</td>
                                <td>
                                    <template x-if="challenge.answer == placeholder">
                                        <div class="w-16">
                                            <input x-model.number="challenge.answer_given" @keyup.enter="checkAnswer(challenge)" type="number" class="w-full block p-2 border border-indigo-500 rounded text-center focus:outline focus:outline-4 focus:-outline-offset-2 focus:outline-pink-500" min="0" step="1">
                                        </div>
                                    </template>
                                    <template x-if="challenge.answer != placeholder">
                                        <div class="w-16" x-text="challenge.answer"></div>
                                    </template>
                                </td>
                                <td class="text-left print:hidden">
                                    <button type="button" x-on:click="checkAnswer(challenge)" class="whitespace-nowrap rounded-md px-5 py-3.5 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2" :class="challenge.check_button_classes">
                                        <span x-show="challenge.correct">Correct! Well Done <i class="ml-1 fa fa-face-smile-hearts text-white"></i></span>
                                        <span x-show="challenge.checked && !challenge.correct">Sorry, that's not right <i class="ml-1 fa-regular fa-face-thinking text-orange-500"></i></span>
                                        <span x-show="!challenge.checked">Check Answer <i class="ml-1 fa fa-check-to-slot text-white"></i></span>
                                    </button>
                                </td>
                                <td class="text-left print:hidden">
                                    <button type="button" x-show="!challenge.correct" x-on:click="tryAgain(challenge)" class="whitespace-nowrap rounded-md border border-pink-500 text-pink-500 px-5 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-pink-500 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600"><i class="ml-1 fa-light fa-redo-alt"></i> Try Again</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </template>
            <template x-if="challenge_type == 'word'">
                <table class="table-fixed border-separate border-spacing-4 text-xl text-center" x-show="challenges">
                    <tbody>
                        <template x-for="challenge in challenges" :key="challenge.id">
                            <tr>
                                <td class="text-left">
                                    <span x-text="challenge.wording"></span>
                                </td>
                                <td>&equals;</td>
                                <td>
                                    <div class="w-16">
                                        <input x-model.number="challenge.answer_given" @keyup.enter="checkAnswer(challenge)" type="text" class="w-full block p-2 border border-indigo-500 rounded text-center focus:outline focus:outline-4 focus:-outline-offset-2 focus:outline-pink-500" min="0" step="1">
                                    </div>
                                </td>
                                <td class="text-left print:hidden">
                                    <button type="button" x-on:click="checkAnswer(challenge)" class="whitespace-nowrap rounded-md px-5 py-3.5 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2" :class="challenge.check_button_classes">
                                        <span x-show="challenge.correct">Correct! Well Done <i class="ml-1 fa fa-face-smile-hearts text-white"></i></span>
                                        <span x-show="challenge.checked && !challenge.correct">Sorry, that's not right <i class="ml-1 fa-regular fa-face-thinking text-orange-500"></i></span>
                                        <span x-show="!challenge.checked">Check Answer <i class="ml-1 fa fa-check-to-slot text-white"></i></span>
                                    </button>
                                </td>
                                <td class="text-left print:hidden">
                                    <button type="button" x-show="!challenge.correct" x-on:click="tryAgain(challenge)" class="whitespace-nowrap rounded-md border border-pink-500 text-pink-500 px-5 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-pink-500 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600"><i class="ml-1 fa-light fa-redo-alt"></i> Try Again</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </template>
        </div>
        <div class="print:hidden mt-4" :class="challenges.length ? 'border-t border-pink-500 pt-4' : null">
            <label for="challenge-target" class="block w-full">
                <span class="font-bold">Challenge <span x-text="challenge_type == 'operator' ? 'Target' : 'Maximum'"></span>:</span>
                <input id="challenge-target" x-model.number="challenge_target" type="text" class="w-16 p-2 border border-indigo-500 rounded text-center relative" style="top: 1px;">
            </label>
            <label class="block w-full mt-2">
                <span class="font-bold">Mathematical Operator:</span>
                <button
                    type="button"
                    class="ml-1 pt-0.5 pb-1 px-4 text-2xl border border-pink-500 rounded"
                    :class="operator == 'Addition' ? 'bg-pink-500 text-white' : 'bg-white text-pink-500'"
                    x-on:click="setChallengeType('operator', 'Addition', '&plus')">&plus;</button>
                <button
                    type="button"
                    class="ml-1 pt-0.5 pb-1 px-4 text-2xl border border-pink-500 rounded"
                    :class="operator == 'Subtraction' ? 'bg-pink-500 text-white' : 'bg-white text-pink-500'"
                    x-on:click="setChallengeType('operator', 'Subtraction', '&minus;')">&minus;</button>
                <!-- <button
                    type="button"
                    class="ml-1 pt-0.5 pb-1 px-4 text-2xl border border-pink-500 rounded"
                    :class="operator == 'Multiplication' ? 'bg-pink-500 text-white' : 'bg-white text-pink-500'"
                    x-on:click="setChallengeType('operator', 'Multiplication', '&times;')">&times;</button> -->
                <!-- <button
                    type="button"
                    class="ml-1 pt-0.5 pb-1 px-4 text-2xl border border-pink-500 rounded"
                    :class="operator == 'Division' ? 'bg-pink-500 text-white' : 'bg-white text-pink-500'"
                    x-on:click="setChallengeType('operator', 'Division', '&divide;')">&divide;</button> -->
                <button
                    type="button"
                    class="ml-1 pt-0.5 pb-1 px-4 text-2xl border border-pink-500 rounded"
                    :class="word_challenge == 'Doubles' ? 'bg-pink-500 text-white' : 'bg-white text-pink-500'"
                    x-on:click="setChallengeType('word', 'Doubles')">Doubles</button>
                <button
                    type="button"
                    class="ml-1 pt-0.5 pb-1 px-4 text-2xl border border-pink-500 rounded"
                    :class="word_challenge == 'Triples' ? 'bg-pink-500 text-white' : 'bg-white text-pink-500'"
                    x-on:click="setChallengeType('word', 'Triples')">Triples</button>
            </label>
            <button type="button" x-on:click="generateChallenges()" class="inline-block whitespace-nowrap mt-4 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Make <span x-text="operator"></span> Challenges <i class="ml-1 fa-light fa-rotate text-white"></i></button>
        </div>
    </div>

    <script>
        function mathsMountain() {
            return {
                challenge_count: 10,
                challenge_target: 20,
                challenge_type: 'operator',
                operator: 'Addition',
                operator_symbol: '&plus;',
                placeholder: '#',
                word_challenge: null,
                challenges: [],
                setChallengeType(type, name, symbol) {
                    this.challenges = [];
                    this.challenge_type = type;
                    this.operator = null;
                    this.operator_symbol = null;
                    this.word_challenge = null
                    if(this.challenge_type === 'operator') {
                        this.setOperator(name, symbol);
                    } else if(this.challenge_type === 'word') {
                        this.setWordChallenge(name);
                    }
                },
                createOperatorChallenge(inputId, firstNumber, secondNumber) {
                    let challengeAnswer = null;
                    let blankedOutInt = Math.ceil(Math.random() * 2);
                    if(blankedOutInt === 1) {
                        challengeAnswer = firstNumber;
                    } else if(blankedOutInt === 2) {
                        challengeAnswer = secondNumber;
                    } else if(blankedOutInt === 3) {
                        challengeAnswer = this.challenge_target;
                    }
                    this.challenges.push({
                        id: inputId,
                        first_number: blankedOutInt === 1 ? this.placeholder : firstNumber,
                        second_number: blankedOutInt === 2 ? this.placeholder : secondNumber,
                        answer: blankedOutInt === 3 ? this.placeholder : this.challenge_target,
                        correct: false,
                        answer_given: null,
                        actual_answer: challengeAnswer,
                        checked: false,
                        check_button_classes: 'border-indigo-600 bg-indigo-600 hover:bg-indigo-500 focus-visible:outline-indigo-600 text-white',
                    });
                },
                createWordChallenge() {
                    if(this.word_challenge == 'Doubles') {
                        let doubleNumber = Math.ceil(Math.random() * Math.floor(this.challenge_target / 2));
                        let wording = `${doubleNumber} + ${doubleNumber}`;
                        if(Math.random() > 0.5) {
                            wording = 'Double ' + doubleNumber;
                        }
                        this.challenges.push({
                            id: this.challenges.length,
                            actual_answer: Math.round(doubleNumber * 2),
                            correct: false,
                            answer_given: null,
                            checked: false,
                            wording: wording,
                            check_button_classes: 'border-indigo-600 bg-indigo-600 hover:bg-indigo-500 focus-visible:outline-indigo-600 text-white',
                        });
                    }
                    if(this.word_challenge == 'Triples') {
                        let tripleNumber = Math.ceil(Math.random() * Math.floor(this.challenge_target / 2));
                        let wording = `${tripleNumber} + ${tripleNumber} + ${tripleNumber}`;
                        if(Math.random() > 0.5) {
                            wording = 'Triple ' + tripleNumber;
                        }
                        this.challenges.push({
                            id: this.challenges.length,
                            actual_answer: Math.round(tripleNumber * 3),
                            correct: false,
                            answer_given: null,
                            checked: false,
                            wording: wording,
                            check_button_classes: 'border-indigo-600 bg-indigo-600 hover:bg-indigo-500 focus-visible:outline-indigo-600 text-white',
                        });
                    }
                },
                generateChallenges() {
                    this.resetChallenges();
                    if(this.challenge_type == 'operator') {
                        for (let i = 0; i < this.challenge_count; i++) {
                            if(this.operator === 'Addition') {
                                let firstNumber = Math.ceil(Math.random() * (this.challenge_target - 1));
                                let secondNumber = this.challenge_target - firstNumber;
                                this.createOperatorChallenge(i, firstNumber, secondNumber);
                            } else if(this.operator === 'Subtraction') {
                                let firstNumber = Math.ceil((1+ Math.random()) * (this.challenge_target - 1));
                                let secondNumber = firstNumber - this.challenge_target;
                                this.createOperatorChallenge(i, firstNumber, secondNumber);
                            } else if(this.operator === 'Multiplication') {
                            } else if(this.operator === 'Division') {
                            }
                        }
                    }
                    if(this.challenge_type == 'word') {
                        for (let i = 0; i < this.challenge_count; i++) {
                            this.createWordChallenge();
                        }
                    }
                },
                setOperator(operator, operatorSymbol) {
                    this.operator = operator;
                    this.operator_symbol = operatorSymbol;
                },
                setWordChallenge(name) {
                    this.word_challenge = name;
                },
                resetChallenges() {
                    this.challenges = [];
                },
                checkAnswer(challenge) {
                    challenge.checked = true;
                    if(challenge.answer_given === null) {
                        this.challenges[challenge.id].checked = false;
                    } else if(challenge.answer_given == challenge.actual_answer) {
                        challenge.correct = true;
                        challenge.check_button_classes = 'bg-green-600 hover:bg-green-500 focus-visible:outline-green-600 text-white';
                    } else {
                        challenge.correct = false;
                        challenge.check_button_classes = 'bg-white border border-orange-500 text-orange-500 hover:bg-white focus-visible:outline-orange-600';
                    }
                },
                tryAgain(challenge) {
                    this.checkAnswer(challenge);
                    if(!challenge.correct) {
                        challenge.answer_given = null;
                        challenge.checked = false;
                        challenge.check_button_classes = 'border-indigo-600 bg-indigo-600 hover:bg-indigo-500 focus-visible:outline-indigo-600 text-white';
                    }
                }
            }
        }
    </script>
</body>
</html>
