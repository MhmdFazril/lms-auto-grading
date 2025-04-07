<script>
    $(document).ready(function() {
        $('trix-editor').removeAttr('contenteditable')
    })

    $(document).on('click', '#saveCorrection', function(e) {
        e.preventDefault()

        let formData = new FormData();
        let attempt_id = $('#attempt_id').val()
        let student_id = $('#student_id').val()
        let content_id = $('#content_id').val()
        let scoreInput = [];

        formData.append('attempt_id', attempt_id)
        formData.append('student_id', student_id)
        formData.append('content_id', content_id)

        $('.score-input').each(function(idx, item) {
            let answerId = $(item).data('id');
            let answerScore = $(item).val();

            scoreInput.push({
                answer_id: answerId,
                score: answerScore
            });

            // formData.append('score-' + answerId, answerScore);
        })

        formData.append('score', JSON.stringify(scoreInput));

        sendAjax("{{ route('course.content.correct-question-save') }}", formData)
            .then(response => {
                if (response.success) {
                    toastr.success(response.message)
                } else {
                    toastr.error('gagal menyimpan')
                }
            })
            .catch(error => {
                toastr.error("Terjadi kesalahan sistem");
            });
    })
</script>
