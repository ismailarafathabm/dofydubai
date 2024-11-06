export const ProductModel = () => {
    const model = {
        _id: "",
        deviceType: "",
        deviceBrand : "",
        deviceModel : "",
        deviceRamRom: "",
        deviceFullName : ""
    }
}

export const ProductModelGrid = () => {
    const xc = [];
    if (useraccess.devicesettings.models.edit) {
        xc.push({
            headerName: "Edit",
            field: "_edit",
            cellRenderer: (p) => `<img  src="${url}/assets/img/icons/edit.svg"/>`,
            width: 50
        });
    }
    if (useraccess.devicesettings.models.delete) {
        xc.push({
            headerName: "Delete",
            field: "_delete",
            cellRenderer: (p) => `<img  src="${url}/assets/img/icons/delete-2.svg"/>`,
            width: 50
        });
    }
    xc.push({
        headerName: 'Type',
        field: 'deviceType',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 140,
    })
    xc.push({
        headerName: 'Brand',
        field: 'deviceBrand',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 140,
    })
   
    xc.push({
        headerName: 'Model',
        field: 'deviceFullName',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 350,
    })
    
    xc.push({
        headerName: 'RAM/ROM',
        field: 'deviceRamRom',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 140,
    })
    xc.push({
        headerName: 'Available stock',
        field: 'instock',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 140,
    })
    if (useraccess.devicesettings.models.priceview) {
        xc.push({
            headerName: 'Stock Value',
            field: 'instockval',
            filter: 'agMultiColumnFilter',
            sortingOrder: ['asc', 'desc'],
            width: 140,
        })
    }
    return xc;
}