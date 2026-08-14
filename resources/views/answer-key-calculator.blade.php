@extends('layouts.app')

@section('title', 'Rank & Score Calculator - Answer Key Marks & Rank Predictor 2026')
@section('meta_description', 'Calculate your total exam marks, negative penalties, normalized score, and all-India rank prediction using your official Answer Key URL.')

@push('styles')
<style>
    .calculator-wrapper {
        background: #f8fafc;
        min-height: 80vh;
        padding: 40px 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .calculator-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        max-width: 720px;
        margin: 0 auto;
    }

    .calculator-card-header {
        background: #ffffff;
        padding: 25px 30px 10px 30px;
        text-align: center;
        border-bottom: 1px solid #f1f5f9;
    }

    .calculator-card-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .calculator-card-header p {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 0;
    }

    .calculator-card-body {
        padding: 30px;
    }

    .form-group-custom {
        margin-bottom: 20px;
    }

    .form-label-custom {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
        display: block;
    }

    .required-tag {
        color: #ef4444;
        font-weight: 600;
    }

    .optional-tag {
        color: #94a3b8;
        font-weight: 400;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-custom, .select-custom {
        width: 100%;
        padding: 12px 16px;
        font-size: 14px;
        color: #1e293b;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        transition: all 0.2s ease;
        outline: none;
    }

    .input-custom:focus, .select-custom:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .btn-paste {
        position: absolute;
        right: 8px;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #475569;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-paste:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .agree-checkbox {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 13px;
        color: #475569;
        margin-bottom: 24px;
        cursor: pointer;
    }

    .agree-checkbox input {
        margin-top: 3px;
        width: 16px;
        height: 16px;
        accent-color: #2563eb;
        cursor: pointer;
    }

    .btn-calculate {
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        color: #ffffff;
        font-size: 16px;
        font-weight: 700;
        padding: 14px;
        width: 100%;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
    }

    .btn-calculate:hover {
        background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }

    /* Result Dashboard Styles */
    .result-dashboard {
        display: none;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 2px dashed #e2e8f0;
    }

    .result-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .result-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .score-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .score-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px;
        text-align: center;
    }

    .score-card .val {
        font-size: 20px;
        font-weight: 800;
        line-height: 1.2;
    }

    .score-card .lbl {
        font-size: 11px;
        color: #64748b;
        margin-top: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .rank-highlight-box {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .rank-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        text-align: center;
    }

    .rank-item h4 {
        font-size: 22px;
        font-weight: 800;
        color: #1e40af;
        margin: 0;
    }

    .rank-item p {
        font-size: 11px;
        color: #3b82f6;
        margin: 0;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-badge-safe {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        display: inline-block;
    }
</style>
@endpush

@section('content')
<div class="calculator-wrapper">
    <div class="container">
        
        <!-- Calculator Form Card -->
        <div class="calculator-card">
            <div class="calculator-card-header">
                <h1>Answer Key Calculator - Rank &amp; Score Calculator</h1>
                <p>Paste your Official Answer Key / Candidate Response Sheet URL to calculate marks and rank prediction.</p>
            </div>

            <div class="calculator-card-body">
                <form id="answerKeyCalcForm" onsubmit="event.preventDefault(); processScoreAndRankCalculation();">
                    
                    <!-- Answer Key URL -->
                    <div class="form-group-custom">
                        <label class="form-label-custom">
                            Answer Key URL <span class="required-tag">(Required)</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="url" id="inputAnswerKeyUrl" class="input-custom" 
                                   placeholder="Paste official answer key / response sheet URL here..." required>
                            <button type="button" class="btn-paste" onclick="pasteAnswerKeyUrl()">
                                <i class="fas fa-paste me-1"></i> Paste
                            </button>
                        </div>
                        <small class="text-muted mt-1 d-block" style="font-size: 11px;">
                            Supported: SSC, UPSSSC, Railway RRB, NTA NEET/JEE, Police, &amp; All DigiALM URLs.
                        </small>
                    </div>

                    <!-- Category -->
                    <div class="form-group-custom">
                        <label class="form-label-custom">
                            Category <span class="required-tag">(Required)</span>
                        </label>
                        <select id="selectCategory" class="select-custom" required>
                            <option value="">Select Category</option>
                            <option value="UR">UR / Unreserved (General)</option>
                            <option value="OBC">OBC (Other Backward Classes)</option>
                            <option value="EWS">EWS (Economically Weaker Section)</option>
                            <option value="SC">SC (Scheduled Caste)</option>
                            <option value="ST">ST (Scheduled Tribe)</option>
                        </select>
                    </div>

                    <!-- Horizontal Reservation -->
                    <div class="form-group-custom">
                        <label class="form-label-custom">
                            Horizontal Reservation <span class="optional-tag">(Optional)</span>
                        </label>
                        <select id="selectReservation" class="select-custom">
                            <option value="None">None</option>
                            <option value="ESM">Ex-Servicemen (ESM)</option>
                            <option value="PH">PWD / PH (Person with Disability)</option>
                            <option value="FF">Freedom Fighter Dependent</option>
                            <option value="SP">Sports Person</option>
                        </select>
                    </div>

                    <!-- Gender -->
                    <div class="form-group-custom">
                        <label class="form-label-custom">
                            Gender <span class="required-tag">(Required)</span>
                        </label>
                        <select id="selectGender" class="select-custom" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Transgender">Transgender</option>
                        </select>
                    </div>

                    <!-- State -->
                    <div class="form-group-custom">
                        <label class="form-label-custom">
                            State <span class="required-tag">(Required)</span>
                        </label>
                        <select id="selectState" class="select-custom" required>
                            <option value="">Select State</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                            <option value="Delhi">Delhi (NCT)</option>
                            <option value="Bihar">Bihar</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                            <option value="Haryana">Haryana</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="West Bengal">West Bengal</option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="Uttarakhand">Uttarakhand</option>
                            <option value="Chhattisgarh">Chhattisgarh</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                            <option value="Other">Other State / UT</option>
                        </select>
                    </div>

                    <!-- Agreement Checkbox -->
                    <label class="agree-checkbox">
                        <input type="checkbox" id="checkAgree" checked required>
                        <span>I agree to share Answer key and Form data for score calculation and rank prediction.</span>
                    </label>

                    <!-- Calculate Button -->
                    <button type="submit" id="btnCalculate" class="btn-calculate">
                        <i class="fas fa-calculator me-1"></i> Calculate
                    </button>
                </form>

                <!-- Result Dashboard Container -->
                <div id="resultDashboard" class="result-dashboard">
                    <div class="result-header">
                        <h3><i class="fas fa-trophy text-warning me-2"></i> Rank &amp; Score Summary Report</h3>
                        <p class="text-muted small">Generated based on candidate response analysis &amp; normalisation algorithm.</p>
                    </div>

                    <!-- Rank Prediction Box -->
                    <div class="rank-highlight-box">
                        <div class="rank-grid">
                            <div class="rank-item">
                                <h4 id="valOverallRank">#284</h4>
                                <p>All-India Rank</p>
                            </div>
                            <div class="rank-item">
                                <h4 id="valCategoryRank">#62</h4>
                                <p>Category Rank</p>
                            </div>
                            <div class="rank-item">
                                <h4 id="valStateRank">#38</h4>
                                <p>State Rank</p>
                            </div>
                        </div>
                    </div>

                    <!-- Scores Cards Grid -->
                    <div class="score-cards-grid">
                        <div class="score-card">
                            <div class="val text-success" id="valPositiveMarks">+148.00</div>
                            <div class="lbl">Positive Score</div>
                        </div>
                        <div class="score-card">
                            <div class="val text-danger" id="valNegativeMarks">-12.50</div>
                            <div class="lbl">Negative Penalty</div>
                        </div>
                        <div class="score-card">
                            <div class="val text-primary" id="valNetScore">135.50</div>
                            <div class="lbl">Raw Net Score</div>
                        </div>
                        <div class="score-card">
                            <div class="val text-purple" style="color: #7c3aed;" id="valNormalizedScore">139.80</div>
                            <div class="lbl">Normalized Score</div>
                        </div>
                    </div>

                    <!-- Qualification Status & Summary -->
                    <div class="p-3 rounded bg-light border text-center">
                        <div class="mb-2">
                            <span class="status-badge-safe" id="valStatusBadge">
                                <i class="fas fa-check-circle me-1"></i> Safe Zone - High Selection Chance
                            </span>
                        </div>
                        <div class="d-flex justify-content-around text-muted small mt-3 pt-2 border-top">
                            <span>Attempted: <strong class="text-dark" id="valAttempted">92 / 100</strong></span>
                            <span>Correct: <strong class="text-success" id="valCorrect">74</strong></span>
                            <span>Wrong: <strong class="text-danger" id="valWrong">18</strong></span>
                            <span>Percentile: <strong class="text-primary" id="valPercentile">98.45%</strong></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
async function pasteAnswerKeyUrl() {
    try {
        const text = await navigator.clipboard.readText();
        if (text) {
            document.getElementById('inputAnswerKeyUrl').value = text;
        }
    } catch (err) {
        alert('Please paste the Answer Key URL manually into the input box.');
    }
}

function processScoreAndRankCalculation() {
    const url = document.getElementById('inputAnswerKeyUrl').value.trim();
    const category = document.getElementById('selectCategory').value;
    const gender = document.getElementById('selectGender').value;
    const state = document.getElementById('selectState').value;
    const agree = document.getElementById('checkAgree').checked;

    if (!url) {
        alert('Please enter or paste your Answer Key URL.');
        return;
    }
    if (!category || !gender || !state) {
        alert('Please select your Category, Gender, and State.');
        return;
    }
    if (!agree) {
        alert('Please accept the agreement checkbox to proceed.');
        return;
    }

    const btn = document.getElementById('btnCalculate');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Analyzing Response Sheet...';

    fetch('{{ route("answer-key-calculator.submit") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            answer_key_url: url,
            category: category,
            horizontal_reservation: document.getElementById('selectReservation').value,
            gender: gender,
            state: state
        })
    })
    .then(res => res.json())
    .then(res => {
        btn.disabled = false;
        btn.innerHTML = originalText;

        if (res.success && res.data) {
            const data = res.data;
            document.getElementById('valOverallRank').innerText = '#' + data.overall_rank;
            document.getElementById('valCategoryRank').innerText = '#' + data.category_rank;
            document.getElementById('valStateRank').innerText = '#' + data.state_rank;

            document.getElementById('valPositiveMarks').innerText = '+' + parseFloat(data.positive_marks).toFixed(2);
            document.getElementById('valNegativeMarks').innerText = '-' + parseFloat(data.negative_marks).toFixed(2);
            document.getElementById('valNetScore').innerText = parseFloat(data.net_score).toFixed(2);
            document.getElementById('valNormalizedScore').innerText = parseFloat(data.normalized_score).toFixed(2);

            document.getElementById('valAttempted').innerText = (data.correct_answers + data.wrong_answers) + ' / ' + data.total_questions;
            document.getElementById('valCorrect').innerText = data.correct_answers;
            document.getElementById('valWrong').innerText = data.wrong_answers;
            document.getElementById('valPercentile').innerText = parseFloat(data.percentile).toFixed(2) + '%';

            const dashboard = document.getElementById('resultDashboard');
            dashboard.style.display = 'block';
            dashboard.scrollIntoView({ behavior: 'smooth' });
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = originalText;
        alert('Failed to calculate score. Please check your Answer Key URL.');
    });
}
</script>
@endpush
