/*
|--------------------------------------------------------------------------
| Editor.jsx 
|--------------------------------------------------------------------------
|
| Editorjs Wrapper Component.
*/

import { useEffect, useRef } from "react";
import EditorJS from "@editorjs/editorjs";
import Header from "@editorjs/header";
import List from "@editorjs/nested-list";
import Image from "@editorjs/image";
import Embed from "@editorjs/embed";
import Table from "@editorjs/table";
import Quote from "@editorjs/quote";
import Underline from "@editorjs/underline";
import Attaches from "@editorjs/attaches";
import Delimiter from "@editorjs/delimiter";
import TextVariantTune from "@editorjs/text-variant-tune";

export default function Editor({ data, onChange, readOnly = false }) {
    const editorRef = useRef(null);
    useEffect(() => {
        const editor = new EditorJS({
            holder: editorRef.current,
            readOnly,
            tools: {
                header: Header,
                list: List,
                image: {
                    class: Image,
                    config: {
                        endpoints: {
                            byFile: route("upload.store"),
                        },
                    },
                },
                embed: {
                    class: Embed,
                    config: {
                        services: {
                            youtube: true,
                            imgur: true,
                            pintrest: true,
                            scratch: {
                                regex: /https?:\/\/scratch.mit.edu\/projects\/(\d+)/,
                                embedUrl:
                                    "https://scratch.mit.edu/projects/<%= remote_id %>/embed",
                                html: '<iframe allowtransparency="true" width="485" height="402" frameborder="0" scrolling="no" allowfullscreen></iframe>',
                                height: 402,
                                width: 485,
                            },
                        },
                    },
                },
                table: Table,
                quote: Quote,
                underline: Underline,
                attaches: {
                    class: Attaches,
                    config: {
                        endpoint: route("upload.store"),
                    },
                },
                delimiter: Delimiter,
                textVariantTune: TextVariantTune,
            },
            tunes: ["textVariantTune"],
            data: data,
            onChange: onChange,
        });

        return () => {
            editor.isReady.then(() => {
                editor.destroy();
            });
        };
    }, []);

    return <div ref={editorRef}></div>;
}
