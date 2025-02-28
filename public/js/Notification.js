function updateNotiCount(log, currentUserId, currentUserName) {
    var activityLogContainer = document.querySelector(
        ".activity-log-container"
    );

    var notiCount = document.getElementById("notiCount");

    if (log.createable_id !== currentUserId) {
        notiCount.innerText = parseInt(notiCount.innerText) + 1;
    }

    activityLogContainer.prepend(createNotiItem(log, currentUserName));

    if (activityLogContainer.children.length > 4) {
        activityLogContainer.lastElementChild.remove();
    }
}

function createNotiItem(log, currentUserName) {
    var activityLog = document.createElement("div");
    activityLog.className = "pb-3";

    activityLog.innerHTML = `
    <a href="/user" onclick="handleActivityLogClick(event)"><div class="flex gap-2">
        <i class="fa-solid mt-1 fa-circle-exclamation text-noti text-[15px] "></i>
        <div class="border-b pb-2">
            <h1 class="mb-1 font-semibold">${log.title}</h1>
            <h1 class="text-paraColor">${currentUserName} ${
        log.activity
    } at ${dateFormat(log.created_at)}</h1>
        </div>
    </div></a>
`;

    return activityLog;
}

function dateFormat(dateString) {
    var options = {
        day: "2-digit",
        month: "short",
        year: "numeric",
    };

    const formattedDate = new Date(dateString).toLocaleDateString(
        undefined,
        options
    );

    const [day, month, year] = formattedDate.split(" ");
    return `${day} ${month} ${year}`;
}
