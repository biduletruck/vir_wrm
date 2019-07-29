function sanBarJs($imput) {
    window.addEventListener('load', function () {
        let selectedDeviceId;
        const codeReader = new ZXing.BrowserMultiFormatReader()
        codeReader.getVideoInputDevices()
            .then((videoInputDevices) => {
                const sourceSelect = document.getElementById('sourceSelect')
                selectedDeviceId = videoInputDevices[0].deviceId
                if (videoInputDevices.length >= 1) {
                    videoInputDevices.forEach((element) => {
                        const sourceOption = document.createElement('option')
                        sourceOption.text = element.label
                        sourceOption.value = element.deviceId
                        sourceSelect.appendChild(sourceOption)
                    })
                    sourceSelect.onchange = () => {
                        selectedDeviceId = sourceSelect.value;
                    };
                    const sourceSelectPanel = document.getElementById('sourceSelectPanel')
                    sourceSelectPanel.style.display = 'block'
                }

                document.getElementById('startButton').addEventListener('click', () => {
                    document.getElementById($imput).value = '';
                    codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (result, err) => {
                        if (result) {
                            document.getElementById($imput).value = result.text
                            codeReader.reset()
                            $('#_scanBar').modal('hide');
                        }
                        if (err && !(err instanceof ZXing.NotFoundException)) {
                            document.getElementById('result').textContent = err
                        }
                    })
                })

                document.getElementById('resetButton').addEventListener('click', () => {
                    codeReader.reset()
                    document.getElementById($imput).value = '';
                })
            })
            .catch((err) => {
                console.error(err)
            })
        $('.closemodal').click(function() {
            codeReader.reset()
            $('.modal').modal('hide')

        })

        $(function(){
            $('.modal').on('hide.bs.modal', function (e) {
                codeReader.reset()
            })
        })
    })
}