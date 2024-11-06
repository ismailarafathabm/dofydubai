export default class API_Services {
    #def_url = `${url}api/`;
    getCurrentdate() {
        const d = new Date();
        return `${d.getDate()}-${d.getMonth() + 1}-${d.getFullYear()}`;
    }
    async GET(page) {
        const url = this.#def_url + page;
        const pd = {
            method: "GET",
            headers: {
                'GTOKEN': gbtoken
            }
        }
        // console.log(pd);
        return await this.fetchdatas(url, pd);
    }
    async POST(page, fd = new FormData()) {
        const url = this.#def_url + page;
        const pd = {
            method: "POST",
            body: fd,
            headers: {
                'GTOKEN': gbtoken
            }
        }
        // console.log(pd);
        return await this.fetchdatas(url, pd);
    }
    async fetchdatas(aurl, pd) {
        const req = await fetch(aurl, pd)
        m === "0" ? console.log(req.status) : "";
        if (req.status === 200 || req.status === 201) {
            try {
                const res = await req.json();
                return res;
            } catch (e) {
                console.log(e.message);

                return { isSuccess: false, data: [], msg: "Error on calling datas - contact admin" };
            }
        } else {
            if (req.status === 402 || req.status === 403) {
                alert("un Authorized User , Please Relogin");
                location.href = `${url}/logout.php`;
                return;
            }
            try {
                const res = await req.json();
                return res;
            } catch (e) {
                console.log(e.message);
                return { isSuccess: false, data: [], msg:"Error on calling datas - contact admin"  };
            }
        }
    }

    _gridOptions(columndef) {
        const _gridOptions = {
            suppressContextMenu: true,
            columnDefs: columndef,
            enableCellChangeFlash: true,
            defaultColDef: {

                sortable: true,
                filter: true,
                floatingFilter: true,
                wrapText: true,
                resizable: true,
            },
            suppressMenuHide: true,
            colResizeDefault: 'shift',
            multiSortKey: 'ctrl',
            excelStyles: [{
                id: 'dateType',
                dataType: "dateTime",
                numberFormat: {
                    format: "dd-MMM-yyyy;;;"
                }
            },
            {
                id: 'dateTypes',
                dataType: "dateTime",
                numberFormat: {
                    format: "dd-MMM-yyyy;;;"
                }
            },
            {
                id: 'dateType_green',
                dataType: "dateTime",
                numberFormat: {
                    format: "dd-MMM-yyyy;;;"
                }
            }
            ],
            statusBar: {
                statusPanels: [{
                    statusPanel: 'agFilteredRowCountComponent',
                    align: 'left'
                },
                {
                    statusPanel: 'agTotalAndFilteredRowCountComponent',
                    align: 'left'
                },
                ],
            },
            suppressAutoSize: {
                type: "fitCellContents",
            },
        };

        return _gridOptions;
    }
}