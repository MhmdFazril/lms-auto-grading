<script>
    $(document).ready(function() {
        $('trix-editor').removeAttr('contenteditable')

        calculate_final_score()
    })


    $(document).on('click', '#saveCorrection', function(e) {
        e.preventDefault()
        loading()

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

            let feedback = $(item).nextAll().eq(1).val()

            scoreInput.push({
                answer_id: answerId,
                score: answerScore,
                feedback: feedback,
            });

            // formData.append('score-' + answerId, answerScore);
        })

        formData.append('score', JSON.stringify(scoreInput));

        sendAjax("{{ route('course.content.correct-question-save') }}", formData)
            .then(response => {
                unloading()
                if (response.success) {
                    toastr.success(response.message)
                } else {
                    toastr.error('gagal menyimpan')
                }
            })
            .catch(error => {
                unloading()
                toastr.error("Terjadi kesalahan sistem");
            });
    })


    // $(document).on('click', '.btn-feedback', function() {
    //     let soal = $(this).data('soal')
    //     let jawaban = $(this).data('jawaban')
    //     let kunci = $(this).data('kunci')
    //     let skor = $(this).closest('div').prev().prev().prev().val();
    //     let feedbackTextarea = $(this).closest('div').prev()

    //     // if (skor == null || skor == '' || skor == 0) {
    //     //     toastr.warning('Feedback dapat diberikan jika skor sudah ada')
    //     //     return
    //     // }

    //     // menghilangkan tag html efek dari trix-editor
    //     jawaban = $('<div>').html(jawaban).text();
    //     kunci = $('<div>').html(kunci).text();
    //     soal = $('<div>').html(soal).text();

    //     let prompt = `
    //         Berikan satu paragraf pendek feedback sebagai guru yang bersifat mendidik dan sopan kepada siswa berdasarkan skor kemiripan ${skor} pada jawaban:
    //         "${jawaban}"
    //         Untuk soal:
    //         "${soal}"
    //         Dengan kunci jawaban:
    //         "${kunci}"

    //         Struktur feedback harus berupa paragraf dengan tiga bagian:

    //         1. Penjelasan kesalahan (jika ada), Jelaskan dengan bahasa yang lembut dan mudah dipahami jika ada kekeliruan dalam jawaban siswa. Jika skor kemiripan mendekati 1, berikan apresiasi atas usaha dan pemahaman siswa.

    //         2. Informasi yang benar, Jelaskan secara singkat dan jelas jawaban yang benar, berdasarkan kunci jawaban.

    //         3. Saran konkret, Berikan saran langkah-langkah atau cara belajar yang bisa membantu siswa memahami materi lebih baik.

    //         4. Motivasi siswa untuk lebih semangat lagi belajar nya

    //         Gunakan gaya bahasa yang ramah, membangun, dan edukatif, seperti layaknya guru yang memberikan bimbingan personal atau berbicara langsung kepada siswa. Hindari nada menghakimi atau terlalu formal, berikan pujian atas kerja keras siswa.
    //     `;

    //     loading()
    //     $.ajax({
    //         url: 'http://127.0.0.1:11434/api/chat',
    //         method: 'POST',
    //         contentType: 'application/json',
    //         data: JSON.stringify({
    //             model: 'gemma:2b-instruct',
    //             messages: [{
    //                 role: 'user',
    //                 content: prompt
    //             }],
    //             stream: false,
    //             options: {
    //                 temperature: 0.1
    //             }
    //         }),
    //         success: function(response) {
    //             unloading()
    //             toastr.success('Berhasil generate feedback')

    //             feedbackTextarea.text('')

    //             let feedback = response.message.content.replace(/^\*\*.*\*\*$/gm, '').replace(
    //                 /\n{2,}/g, '\n\n');
    //             // console.log(response.message.content)
    //             // console.log('===============')
    //             // console.log(feedback)


    //             feedbackTextarea.text(response.message.content)
    //         },
    //         error: function(xhr, status, error) {
    //             unloading()
    //             toastr.error('Gagal generate feedback')
    //             console.error('Gagal:', error);
    //             console.log('Status:', status);
    //             console.log('Response:', xhr.responseText);
    //         }
    //     });

    // })
    $(document).on('click', '.btn-feedback', function() {
        let soal = $(this).data('soal');
        let jawaban = $(this).data('jawaban');
        let kunci = $(this).data('kunci');
        let skor = $(this).closest('div').prev().prev().prev().val();
        let bobot = $(this).data('bobot');
        let feedbackTextarea = $(this).closest('div').prev();

        // Menghilangkan tag HTML (misalnya dari Trix editor)
        jawaban = $('<div>').html(jawaban).text();
        kunci = $('<div>').html(kunci).text();
        soal = $('<div>').html(soal).text();

        let postData = {
            soal: soal,
            kunci_jawaban: kunci,
            jawaban_siswa: jawaban,
            bobot: bobot,
            skor: skor
        };

        console.log(postData);

        loading();

        $.ajax({
            url: 'http://127.0.0.1:5000/feedback/openrouter',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(postData), // <-- ini dulu kosong
            success: function(response) {
                unloading();
                toastr.success('Berhasil generate feedback');

                if (response.success && response.feedback) {
                    let feedback = response.feedback;
                    let resultText =
                        `✅ Kunci Jawaban:\n${feedback.kunci_jawaban}\n\n` +
                        `❌ Penjelasan Kesalahan:\n${feedback.penjelasan_kesalahan}\n\n` +
                        `💡 Saran Konkret:\n${feedback.saran_konkret}\n\n` +
                        `🔥 Motivasi:\n${feedback.motivasi}`;

                    feedbackTextarea.val(resultText); // asumsi feedbackTextarea = <textarea>
                    toastr.success('Berhasil generate feedback');
                }
            },
            error: function(xhr, status, error) {
                unloading();
                toastr.error('Gagal generate feedback');
                console.error('Gagal:', error);
                console.log('Status:', status);
                console.log('Response:', xhr.responseText);
            }
        });
    });



    // $(document).on('click', '.btn-correction', function() {
    //     let soal = $(this).data('soal')
    //     let jawaban = $(this).data('jawaban')
    //     let kunci = $(this).data('kunci')
    //     let jenis = $(this).data('jenis')
    //     let scoreArea = $(this).closest('div').prev().prev().prev()
    //     let bobot = $(this).closest('div').closest('#question-card').find('.bobot-soal').text()

    //     // ambil angka bobot saja
    //     bobot = parseFloat(bobot.match(/\d+/)?.[0] || '0', 10);

    //     jawaban = $('<div>').html(jawaban).text();
    //     kunci = $('<div>').html(kunci).text();
    //     soal = $('<div>').html(soal).text();

    //     postData = {
    //         soal: soal,
    //         kunci_jawaban: kunci,
    //         jawaban_siswa: jawaban,
    //         jenis_soal: jenis,
    //     }

    //     loading()

    //     $.ajax({
    //         url: 'http://127.0.0.1:5000/penilaian',
    //         method: 'POST',
    //         contentType: 'application/json',
    //         data: JSON.stringify(postData),
    //         success: function(response) {
    //             unloading()
    //             toastr.success('Skor didapatkan')

    //             scoreAreaValue = response.skor * bobot

    //             if (scoreAreaValue != bobot) {
    //                 scoreAreaValue = scoreAreaValue.toFixed(2)
    //             }

    //             if (scoreAreaValue == 0, 00 || scoreAreaValue == 0.00) {
    //                 scoreAreaValue = 0
    //             } else {
    //                 scoreAreaValue = scoreAreaValue
    //             }

    //             scoreArea.val(scoreAreaValue)

    //             let skor = response.skor
    //             let reason = response.reason
    //             let jenis_soal = response.jenis_soal
    //             let treshold = response.treshold
    //             let skor_sebelum = response.skor_sebelum
    //             let soal = response.data.soal
    //             let kunci = response.data.kunci
    //             let jawaban = response.data.jawaban

    //             $('#modal_response_correction')[0].showModal();

    //             $('#modal_response_correction .modal-soal').text(soal)
    //             $('#modal_response_correction .modal-kunci').text(kunci)
    //             $('#modal_response_correction .modal-jawaban').text(jawaban)
    //             $('#modal_response_correction .modal-jenis').text(jenis_soal)
    //             $('#modal_response_correction .modal-alasan').text(reason)
    //             $('#modal_response_correction .modal-skor').text(skor == 1 ? skor : skor
    //                 .toFixed(2))
    //             $('#modal_response_correction .modal-sebelum').text(skor_sebelum)
    //             $('#modal_response_correction .modal-treshold').text(treshold)

    //             $('#modal_response_correction .modal-skorBobot').text(
    //                 `${skor == 1 ? skor : skor.toFixed(2)} x ${bobot} = ${scoreAreaValue}`
    //             )


    //             calculate_final_score()

    //         },
    //         error: function(xhr, status, error) {
    //             unloading()
    //             toastr.error('Terjadi Kesalahan')
    //             console.error('Terjadi kesalahan:', error);
    //         }
    //     });
    // })


    $(document).on('click', '.btn-correction', function() {
        let soal = $(this).data('soal')
        let jawaban = $(this).data('jawaban')
        let kunci = $(this).data('kunci')
        let jenis = $(this).data('jenis')
        let scoreArea = $(this).closest('div').prev().prev().prev()
        let bobot = $(this).closest('div').closest('#question-card').find('.bobot-soal').text()

        // ambil angka bobot saja
        bobot = parseFloat(bobot.match(/\d+/)?.[0] || '0', 10);

        jawaban = $('<div>').html(jawaban).text();
        kunci = $('<div>').html(kunci).text();
        soal = $('<div>').html(soal).text();

        postData = {
            soal: soal,
            kunci_jawaban: kunci,
            jawaban_siswa: jawaban,
            jenis_soal: jenis,
        }

        loading()

        $.ajax({
            url: 'http://127.0.0.1:5000/penilaian',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(postData),
            success: function(response) {
                unloading();
                toastr.success('Skor didapatkan');

                let skor = response.skor;
                let scoreAreaValue = skor * bobot;

                // Format nilai akhir (bulat jika pas, 2 desimal jika tidak)
                if (!Number.isInteger(scoreAreaValue)) {
                    scoreAreaValue = parseFloat(scoreAreaValue.toFixed(2));
                }

                // Jika nol
                if (scoreAreaValue === 0) {
                    scoreAreaValue = 0;
                }

                scoreArea.val(scoreAreaValue); // Masukkan nilai skor ke input

                // Ambil data dari response
                let reason = response.reason;
                let jenis_soal = response.jenis_soal;
                let treshold = response.treshold;
                let skor_sebelum = response.skor_sebelum;
                let soal = response.data.soal;
                let kunci = response.data.kunci;
                let jawaban = response.data.jawaban;

                // Tampilkan modal dan isi datanya
                $('#modal_response_correction')[0].showModal();
                $('#modal_response_correction .modal-soal').text(soal);
                $('#modal_response_correction .modal-kunci').text(kunci);
                $('#modal_response_correction .modal-jawaban').text(jawaban);
                $('#modal_response_correction .modal-jenis').text(jenis_soal);
                $('#modal_response_correction .modal-alasan').text(reason);
                $('#modal_response_correction .modal-skor').text(
                    skor === 1 ? 1 : skor.toFixed(2)
                );
                $('#modal_response_correction .modal-sebelum').text(skor_sebelum);
                $('#modal_response_correction .modal-treshold').text(treshold);

                $('#modal_response_correction .modal-skorBobot').text(
                    `${skor === 1 ? 1 : skor.toFixed(2)} x ${bobot} = ${scoreAreaValue}`
                );

                // Hitung skor akhir (jika ada fungsinya)
                calculate_final_score();
            },
            error: function(xhr, status, error) {
                unloading();
                toastr.error('Terjadi Kesalahan');
                console.error('Terjadi kesalahan:', error);
            }
        });
    })

    $(document).on('keyup', '.score-input', function() {
        let bobot = $(this).closest('#question-card').find('.bobot-soal').text()
        bobot = parseFloat(bobot.match(/\d+/)?.[0] || '0', 10);

        if ($(this).val() > bobot) {
            toastr.warning('Skor tidak boleh melebihi bobot yang sudah ditentukan')
            $(this).val(bobot)
            return
        }

        calculate_final_score()
    })

    function calculate_final_score() {
        let total_nilai = 0;
        $('.score-input').each(function(idx, item) {
            if (item !== null || item !== '') {
                total_nilai += parseFloat($(item).val()) ||
                    0;
            }
        });

        $('#final_score').text(total_nilai);
    }
</script>
