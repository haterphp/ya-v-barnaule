
const Templates = {
    $container() {
        const $element = document.createElement('div');
        $element.className = 'wrap mt-3 mb-3';
        $element.innerHTML = `
            <div class="row mt-3 image-container"></div>
        `;
        return $element;
    },
    $photoCard({ id, url }, key, { name }) {
        const $element = document.createElement('div');
        $element.className = 'col-12 col-sm-4 col-md-6 mt-2';
        $element.innerHTML = `
            <div class="card position-relative">
                <div class="dropdown position-absolute" style="right: 15px; top: 15px">
                    <button class="btn dropdown-toggle not-arrow text-white" type="button" id="category-dropdown-${key}" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="category-dropdown-${key}">
                        <button class="dropdown-item text-danger btn-delete"><i class="fa fa-trash-alt"></i> Удалить</button>
                    </div>
                </div>
                <img style="object-fit: cover; max-height: 250px" src="${url}" alt="image" class="w-100 card-image rounded">
                <input type="text" value="${id}" class="d-none" name="${name}[${key}][id]">
                <input type="text" value="${url}" class="d-none" name="${name}[${key}][url]">
            </div>
        `;
        return $element;
    },
    $appendButton() {
        const $element = document.createElement('div');
        $element.className = 'col-12 col-sm-4 col-md-6 mt-2';
        $element.innerHTML = `
            <label class="card" style="cursor: pointer; border-style: dashed;">
                <input type="file" class="d-none file-upload" multiple>
                <div class="card-body d-flex flex-column align-items-center">
                    <i class="fa fa-download mb-2" style="font-size: 50px; opacity: .3"></i>
                    <p class="card-text text-center text-muted">Выберете файл или просто пертащите его сюда</p>
                </div>
            </label>
        `;
        return $element;
    }
}

const PhotoPreview = function ($container, photos, options = {}) {
    this.$container = $container;
    this.photos = photos;
    this.name = options.name || 'photos';

    this.getUrl = async (file) => {
        const promise = new Promise(resolve => {
            const reader = new FileReader();
            
            reader.readAsDataURL(file);

            reader.onloadend = function () {
                resolve(reader.result);
            }
        })
        return await promise;
    };
    
    this.initAddButton = function() {
        const $btn = Templates.$appendButton();
        $btn.querySelector('.file-upload').addEventListener('change', async (ev) => {
            const photos = await Promise.all(Array.from(ev.target.files, 
                async (file) => ({ id: null, url: await this.getUrl(file)})
            ));
            this.photoAdd(photos);
        });

        const $label = $btn.querySelector('.card'); 

        const highlight = () => {
            $label.classList.add('text-primary')
            $label.classList.add('border-primary')
            $label.querySelector('.card-text').classList.remove('text-muted')
            $label.querySelector('.card-text').classList.add('text-primary')
        }

        const unhighlight = () => {
            $label.classList.remove('text-primary')
            $label.classList.remove('border-primary')
            $label.querySelector('.card-text').classList.add('text-muted')
            $label.querySelector('.card-text').classList.remove('text-primary')
        }

        const preventDefaults = (e) => {
            e.preventDefault();
            e.stopPropagation();
        }

        const handleDrop = async (e) => {
            const photos = await Promise.all(Array.from(e.dataTransfer.files, 
                async (file) => ({ id: null, url: await this.getUrl(file)})
            ));
            this.photoAdd(photos);
        }

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            $label.addEventListener(eventName, preventDefaults, false)
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            $label.addEventListener(eventName, highlight, false)
        });

        ['dragleave', 'drop'].forEach(eventName => {
            $label.addEventListener(eventName, unhighlight, false)
        });

        $label.addEventListener('drop', handleDrop, false);

        this.$photoContainer.append($btn);
    }
    
    this.photoAdd = function (photos) {
        this.photos.push(...photos);
        this.render();
    };

    this.render = function () {
        this.$photoContainer.innerHTML = '';
        this.initAddButton();
        this.photos.forEach((photo, key) => {
            const $photo = Templates.$photoCard(photo, key, { name: this.name });
            $photo.querySelector('.btn-delete').addEventListener('click', () => {
                const idx = this.photos.indexOf(photo);
                if(idx !== -1) this.photos.splice(idx, 1);
                this.render();
            });
            this.$photoContainer.append($photo);
        });
    };

    this.init = function () {
        this.$container.append(Templates.$container());
        this.$photoContainer = this.$container.querySelector('.image-container');
        this.render();
    };

    this.init();
};
