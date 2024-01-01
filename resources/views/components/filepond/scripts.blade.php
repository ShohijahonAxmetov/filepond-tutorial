<!-- README -->
<!-- 1. dlya raboti trebuetsya biblioteka axios -->

<!-- Load FilePond library -->
<script src="/assets/scripts/filepond-plugin-file-poster.js"></script>
<script src="/assets/scripts/filepond-plugin-image-preview.js"></script>
<script src="/assets/scripts/filepond-plugin-image-exif-orientation.js"></script>
<script src="/assets/scripts/filepond-plugin-file-validate-size.js"></script>
<script src="/assets/scripts/filepond.js"></script>
<script>
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginImageExifOrientation,
        FilePondPluginFileValidateSize,
        FilePondPluginFilePoster
    );
    FilePond.create(
        document.querySelector('input[type="file"]'),
    );
    FilePond.setOptions({
        server: {
            process: {
                url: '{{url('/')}}/filepond/process',
                method: 'POST',
                withCredentials: false,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                timeout: 7000,
                onload: null,
                onerror: null,
                ondata: null,
            },
            revert: {
                url: '{{url('/')}}/filepond/revert',
                method: 'DELETE',
                withCredentials: false,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                timeout: 7000,
                onload: null,
                onerror: null,
                ondata: null,
            },
            load: {
                url: '{{url('/')}}/filepond/load?file=',
                method: 'GET',
                withCredentials: false,
                timeout: 7000,
            },
            remove: (source, load) => {
                axios.post('{{url('/')}}/filepond/remove', {
                    file: source
                })
                    .then(function (response) {
                        load();
                    })
                    .catch(function (error) {
                        console.log(error.response.data);
                    });
            }
        },
    });
    @if(isset(session('files')[0]))
    FilePond.setOptions({
        filePosterHeight: 256,
        files: [
                @foreach(session('files') as $sessionFile)
            {
                source: '{{$sessionFile}}',
                options: {
                    type: 'local',
                    metadata: {
                        poster: '{{url('/')}}/storage/{{$sessionFile}}'
                    }
                }
            },
            @endforeach
        ]
    });
    @endif
</script>
