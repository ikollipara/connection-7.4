
import  ImageTool from '@editorjs/image';

export default class ImageOverride extends ImageTool {
    constructor({ data, api, config, readOnly, block }) {
        super({ data, api, config, readOnly, block });
        this.imagesToDelete = config.imagesToDelete || [];
    }

    removed() {
        const data = this._data.file.url;
        this.imagesToDelete.push(data);
    }
}
