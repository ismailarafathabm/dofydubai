export const IUserModel =()=> {
    const i = {
        _id: "",
        userName: "",
        userId: "",
        userPass: "",
        userToken: "",
        userIp: "",
        userLastLogin: "",
        userType: "",
        userStatus: "",
        userCby: "",
        userEby: "",
        userCdate: "",
        userEdate: "",
        passwrongCnt: "",
        userRole: "",
        shopCode : ""
    };
    return i;
    
}
export const userslist = (s,c) => {
    let xc = [];
    xc.push({
        headerName: "Edit",
        field : "_edit",
        cellRenderer: (p) => c(`<img  src="${url}/assets/img/icons/edit.svg"/>`)(s)[0],
        width: 50
    });
    xc.push({
        headerName: "Access",
        cellRenderer: (p) => c(`<img ng-click="edituseraccess('${p.data.userId}')" src="${url}/assets/img/icons/edit-5.svg"/>`)(s)[0],
        width: 50
    });
    xc.push({
        headerName: 'Name',
        field: 'userName',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 140,
    })
    xc.push({
        headerName: 'Login Id',
        field: 'userId',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 140,
    })
    
    xc.push({
        headerName: 'Status',
        field: 'userStatus_txt',
        cellRenderer : (p) => (+p.data.userStatus) === 1 ? `<span class="badges bg-lightgreen">${p.data.userStatus_txt}</span>` :  `<span class="badges bg-lightred">${p.data.userStatus_txt}</span>`,
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 150,
    })

    xc.push({
        headerName: 'Shop Code',
        field: 'shopCode',
        cellRenderer : (p) => `<span class="badges btn-danger">${p.data.shopCode}</span>`,
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 140,
    })
    
    return xc;
}