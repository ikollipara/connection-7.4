
import  AttachesTool from '@editorjs/attaches';

export default class AttachesOverride extends AttachesTool {
    constructor({ data, api, config, readOnly }) {
        super({ data, api, config, readOnly });
        this.attachesToDelete = config.attachesToDelete || [];
    }

    removed() {
        const data = this._data.file.url;
        this.attachesToDelete.push(data);
    }
}
