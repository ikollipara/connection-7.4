
import  ImageTool from '@editorjs/image';

export default class ImageOverride extends ImageTool {
    constructor({ data, api, config }) {
        super({ data, api, config });
        this.imagesToDelete = config.imagesToDelete || [];
    }

    removed() {
        const data = this._data.file.url;
        this.imagesToDelete.push(data);
    }
}
