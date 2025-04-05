<script>
    $(document).ready(function() {
        const time_limit = {{ $content->time_limit }};
        const satuan = '{{ $content->satuan }}';
        const closeQuiz = {{ strtotime($content->close_quiz) }};
        const start_time = {{ strtotime($attempt->start_time) }};
        const now = Math.floor(Date.now() / 1000);

        let totalSeconds;

        if (satuan === 'menit') {
            totalSeconds = time_limit * 60;
        } else if (satuan === 'jam') {
            totalSeconds = time_limit * 3600;
        } else {
            totalSeconds = time_limit;
        }

        let end_attempt_time = start_time + totalSeconds;

        if (end_attempt_time > closeQuiz) {
            totalSeconds = closeQuiz - start_time;
        }

        let durasi = (start_time + totalSeconds) - now

        if (durasi <= 0) {
            formSubmit(0);
            return
        }

        let interval = setInterval(function() {
            if (durasi <= 0) {
                clearInterval(interval);
                formSubmit(0);
                return;
            }

            let hours = Math.floor(durasi / 3600);
            let minutes = Math.floor((durasi % 3600) / 60);
            let seconds = durasi % 60;

            let showHour = hours < 10 ? '0' + hours : hours;
            let showMinute = minutes < 10 ? '0' + minutes : minutes;
            let showSecond = seconds < 10 ? '0' + seconds : seconds;
            $('#hours').css('--value', showHour).attr('aria-label', showHour);
            $('#minutes').css('--value', showMinute).attr('aria-label', showMinute);
            $('#seconds').css('--value', showSecond).attr('aria-label', showSecond);

            durasi--;

            if (totalSeconds < 0) {
                clearInterval(interval);
            }
        }, 1000);
    });

    $(document).on('click', '.question-nav', function(event) {
        event.preventDefault();

        var idxQuestion = parseInt("{{ $idxQuestion }}");

        if ($(this).text() === 'Previous') {
            idxQuestion -= 1;
            $('#finish_attempt').remove()
        } else if ($(this).text() === 'Next') {
            idxQuestion += 1;
            $('#finish_attempt').remove()
        } else {
            idxQuestion = 0
        }

        formSubmit(idxQuestion)
    });

    function formSubmit(idxQuestion) {
        var form = $('#submitForm');

        if (idxQuestion == 0) {
            $('#nav-action').append(
                '<input type="hidden" name="finish_attempt" id="finish_attempt" value="true">'
            );
        }

        var newAction =
            '{{ route('quiz.attempt', ['courseContent' => $content->id, 'idxQuestion' => '__idxQuestion__']) }}';
        newAction = newAction.replace('__idxQuestion__', idxQuestion);

        form.attr('action', newAction);

        form.submit()
    }
</script>
